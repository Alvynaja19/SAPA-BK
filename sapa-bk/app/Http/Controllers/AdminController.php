<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CounselorProfile;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Article;

class AdminController extends Controller
{
    /** Dashboard Admin — /admin/dashboard */
    public function dashboard()
    {
        $stats = [
            'total_siswa'   => User::where('role', 'siswa')->count(),
            'total_guru_bk' => User::where('role', 'guru_bk')->count(),
            'total_admin'   => User::where('role', 'admin')->count(),
            'total_chat'    => ChatSession::count(),
            'total_ebook'   => Ebook::count(),
            'total_artikel' => Article::count(),
        ];
        $recentUsers    = User::latest()->take(5)->get();
        $recentStudents = User::where('role', 'siswa')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentStudents'));
    }

    /** Manajemen user — /admin/users */
    public function users(Request $request)
    {
        $query = User::query()->with(['studentProfile', 'counselorProfile']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        $users = $query->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    /** Detail user — /admin/users/{id} */
    public function userDetail(int $id)
    {
        $user = User::with(['studentProfile', 'counselorProfile'])->findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    /** Buat akun Guru BK / Siswa / Admin */
    public function userStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8',
            'role'         => 'required|in:siswa,guru_bk,admin',
            'phone'        => 'nullable|string|max:20',
            // Guru BK fields
            'nip'          => 'nullable|string|max:30',
            'spesialisasi' => 'nullable|string|max:100',
            // Student fields
            'nisn'         => 'nullable|string|max:20',
            'kelas'        => 'nullable|string|max:20',
            'jurusan'      => 'nullable|string|max:50',
            'tahun_masuk'  => 'nullable|integer|digits:4',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'role'      => $request->role,
                'phone'     => $request->phone,
                'is_active' => true,
            ]);

            if ($request->role === 'guru_bk') {
                CounselorProfile::create([
                    'user_id'      => $user->id,
                    'nip'          => $request->nip,
                    'spesialisasi' => $request->spesialisasi,
                ]);
            } elseif ($request->role === 'siswa') {
                StudentProfile::create([
                    'user_id'     => $user->id,
                    'nisn'        => $request->nisn,
                    'kelas'       => $request->kelas,
                    'jurusan'     => $request->jurusan,
                    'tahun_masuk' => $request->tahun_masuk ?? date('Y'),
                ]);
            }
        });

        return redirect()->route('admin.users')->with('success', 'Akun berhasil dibuat.');
    }

    /** Update user */
    public function userUpdate(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:siswa,guru_bk,admin',
            'is_active' => 'boolean',
        ]);

        $user->update($request->only('name', 'email', 'role', 'is_active'));
        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    /** Hapus user */
    public function userDestroy(int $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    /** Konfigurasi sistem — /admin/konfigurasi */
    public function konfigurasi()
    {
        return view('admin.konfigurasi');
    }

    /** Simpan konfigurasi */
    public function konfigurasiUpdate(Request $request)
    {
        $request->validate([
            'gemini_api_key'       => 'nullable|string',
            'gemini_model'         => 'nullable|string',
            'gemini_temperature'   => 'nullable|numeric|min:0|max:2',
            'chromadb_path'        => 'nullable|string',
            'chromadb_collection'  => 'nullable|string',
            'ai_service_url'       => 'nullable|url',
        ]);

        // Simpan ke config atau .env (via helper)
        foreach ($request->only([
            'gemini_api_key', 'gemini_model', 'gemini_temperature',
            'chromadb_path', 'chromadb_collection', 'ai_service_url'
        ]) as $key => $value) {
            if ($value !== null) {
                \Artisan::call('config:clear');
            }
        }

        return back()->with('success', 'Konfigurasi berhasil disimpan.');
    }

    /** System log — /admin/log */
    public function log()
    {
        return view('admin.log');
    }

    /** Laporan & statistik — /admin/laporan */
    public function laporan()
    {
        return view('admin.laporan');
    }
}
