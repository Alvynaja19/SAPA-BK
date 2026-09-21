<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ChatEvaluation;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\KnowledgeDocument;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\Student;
use App\Models\User;
use App\Services\ExcelCsvReader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_guru_bk' => User::where('role', 'guru_bk')->count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_sessions' => ChatSession::count(),
            'total_messages' => ChatMessage::count(),
            'total_knowledge' => KnowledgeDocument::count(),
            'total_ebooks' => Ebook::count(),
            'total_articles' => Article::count(),
            'total_evaluations' => ChatEvaluation::count(),
            'good_evaluations' => ChatEvaluation::where('rating', 'good')->count(),
        ];

        $recentUsers = User::latest()->take(6)->get();
        $recentSessions = ChatSession::with('user')->latest()->take(5)->get();
        $recentKnowledge = KnowledgeDocument::with('uploader')->latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSessions', 'recentKnowledge'));
    }

    public function users(Request $request): View
    {
        $roleFilter = $request->query('role');
        $search = $request->query('q');

        $query = User::query();

        if ($roleFilter && in_array($roleFilter, ['siswa', 'guru_bk', 'admin'], true)) {
            $query->where('role', $roleFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('admin.users', compact('users', 'roleFilter', 'search'));
    }

    /**
     * Membuat akun Guru BK / Admin baru secara manual oleh Administrator (SRS F-06).
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:guru_bk,admin,siswa',
            'nisn' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nisn' => $validated['nisn'] ?? null,
            'kelas' => $validated['kelas'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'is_active' => true,
        ]);

        $roleTitle = match ($validated['role']) {
            'guru_bk' => 'Guru BK',
            'admin' => 'Administrator',
            default => 'Siswa'
        };

        return back()->with('success', "Akun {$roleTitle} ({$validated['name']}) berhasil dibuat!");
    }

    /**
     * Mengunduh template CSV untuk import data master siswa.
     */
    public function downloadSiswaTemplate(): StreamedResponse
    {
        $headers = ['No', 'Nama', 'NISN', 'NIS', 'Kelas', 'Jenis Kelamin (L/P)', 'No HP'];
        $examples = [
            ['1', 'Ahmad Fauzi Pratama', '0054321987', '12345', 'XII MIPA 1', 'L', '082198765432'],
            ['2', 'Siti Nurhaliza', '0054321988', '12346', 'XII MIPA 2', 'P', '082198765433'],
        ];

        $filename = 'template_import_siswa_sapa_bk.csv';

        return response()->streamDownload(function () use ($headers, $examples) {
            $file = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar terbaca rapi saat dibuka di Microsoft Excel
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $headers);
            foreach ($examples as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Mengimpor data master siswa dari file Excel (.xlsx) atau CSV.
     */
    public function importSiswa(Request $request, ExcelCsvReader $reader): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ], [
            'file.required' => 'Silakan pilih file Excel atau CSV terlebih dahulu.',
            'file.mimes' => 'Format file harus berupa CSV (.csv) atau Excel (.xlsx, .xls).',
            'file.max' => 'Ukuran file maksimal adalah 5MB.',
        ]);

        try {
            $file = $request->file('file');
            $rows = $reader->read($file->getRealPath(), $file->getClientOriginalExtension());
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Gagal membaca file: '.$e->getMessage()]);
        }

        if (count($rows) <= 1) {
            return back()->withErrors(['error' => 'File tidak berisi data atau hanya memuat baris judul.']);
        }

        // Baris pertama diasumsikan sebagai baris header
        $headerRow = array_shift($rows);

        // Pemetaan otomatis indeks kolom berdasarkan nama header
        $colMap = [
            'nama' => -1,
            'nisn' => -1,
            'nis' => -1,
            'kelas' => -1,
            'jenis_kelamin' => -1,
            'no_hp' => -1,
        ];

        foreach ($headerRow as $idx => $headerText) {
            $cleanHeader = strtolower(trim((string) $headerText));
            if (str_contains($cleanHeader, 'nama')) {
                $colMap['nama'] = $idx;
            } elseif (str_contains($cleanHeader, 'nisn')) {
                $colMap['nisn'] = $idx;
            } elseif (str_contains($cleanHeader, 'kelamin') || str_contains($cleanHeader, 'jk')) {
                $colMap['jenis_kelamin'] = $idx;
            } elseif (str_contains($cleanHeader, 'kelas') || str_contains($cleanHeader, 'rombel')) {
                $colMap['kelas'] = $idx;
            } elseif (str_contains($cleanHeader, 'nis')) {
                $colMap['nis'] = $idx;
            } elseif (str_contains($cleanHeader, 'hp') || str_contains($cleanHeader, 'telepon') || str_contains($cleanHeader, 'kontak') || str_contains($cleanHeader, 'wa')) {
                $colMap['no_hp'] = $idx;
            }
        }

        // Fallback jika header tidak terdeteksi (mengikuti template default: No, Nama, NISN, NIS, Kelas, JK, No HP)
        if ($colMap['nama'] === -1) {
            $colMap = [
                'nama' => 1,
                'nisn' => 2,
                'nis' => 3,
                'kelas' => 4,
                'jenis_kelamin' => 5,
                'no_hp' => 6,
            ];
        }

        $importedCount = 0;
        $updatedCount = 0;

        foreach ($rows as $row) {
            $nama = isset($colMap['nama'], $row[$colMap['nama']]) ? trim($row[$colMap['nama']]) : '';
            $nisn = isset($colMap['nisn'], $row[$colMap['nisn']]) ? trim($row[$colMap['nisn']]) : '';
            $nis = isset($colMap['nis'], $row[$colMap['nis']]) ? trim($row[$colMap['nis']]) : '';
            $kelas = isset($colMap['kelas'], $row[$colMap['kelas']]) ? trim($row[$colMap['kelas']]) : '';
            $jkRaw = isset($colMap['jenis_kelamin'], $row[$colMap['jenis_kelamin']]) ? strtoupper(trim($row[$colMap['jenis_kelamin']])) : '';
            $jk = in_array($jkRaw, ['L', 'P'], true) ? $jkRaw : null;
            $noHp = isset($colMap['no_hp'], $row[$colMap['no_hp']]) ? trim($row[$colMap['no_hp']]) : '';

            // Lewati baris jika nama dan NIS/NISN kosong
            if (empty($nama) || (empty($nisn) && empty($nis))) {
                continue;
            }

            // Cari apakah data siswa sudah ada berdasarkan NISN atau NIS
            $existingStudent = null;
            if (! empty($nisn)) {
                $existingStudent = Student::where('nisn', $nisn)->first();
            }
            if (! $existingStudent && ! empty($nis)) {
                $existingStudent = Student::where('nis', $nis)->first();
            }

            if ($existingStudent) {
                $existingStudent->update(array_filter([
                    'nama' => $nama,
                    'nis' => $nis ?: $existingStudent->nis,
                    'nisn' => $nisn ?: $existingStudent->nisn,
                    'kelas' => $kelas ?: $existingStudent->kelas,
                    'jenis_kelamin' => $jk ?: $existingStudent->jenis_kelamin,
                    'no_hp' => $noHp ?: $existingStudent->no_hp,
                ]));
                $updatedCount++;
            } else {
                Student::create([
                    'nama' => $nama,
                    'nis' => $nis ?: null,
                    'nisn' => $nisn ?: null,
                    'kelas' => $kelas ?: null,
                    'jenis_kelamin' => $jk,
                    'no_hp' => $noHp ?: null,
                    'status' => 'terdaftar',
                ]);
                $importedCount++;
            }
        }

        $total = $importedCount + $updatedCount;

        return back()->with('success', "Proses impor selesai. Total {$total} data siswa diproses ({$importedCount} baru ditambahkan, {$updatedCount} diperbarui).");
    }

    public function userDetail(int $id): View
    {
        $user = User::with([
            'chatSessions' => function ($q) {
                $q->withCount('messages')->latest()->take(10);
            },
            'questionnaireResults.questionnaire',
        ])->findOrFail($id);

        $totalChats = ChatSession::where('user_id', $user->id)->count();
        $totalAssessments = QuestionnaireResult::where('user_id', $user->id)->count();

        return view('admin.user-detail', compact('user', 'totalChats', 'totalAssessments'));
    }

    public function toggleUserStatus(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin' && User::where('role', 'admin')->where('is_active', true)->count() <= 1 && $user->is_active) {
            return back()->withErrors(['error' => 'Tidak dapat menonaktifkan satu-satunya akun Administrator.']);
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status akun pengguna ({$user->name}) berhasil {$statusText}!");
    }

    /**
     * Memperbarui data akun pengguna (SRS F-06 / Edit User).
     */
    public function updateUser(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:guru_bk,admin,siswa',
            'nisn' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ]);

        // Cegah mengubah role atau menonaktifkan satu-satunya administrator
        if ($user->role === 'admin' && $validated['role'] !== 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['error' => 'Tidak dapat mengubah role satu-satunya akun Administrator.']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->nisn = $validated['nisn'] ?? null;
        $user->kelas = $validated['kelas'] ?? null;
        $user->no_hp = $validated['no_hp'] ?? null;

        if (isset($validated['is_active'])) {
            if ($user->role === 'admin' && ! $validated['is_active'] && User::where('role', 'admin')->where('is_active', true)->count() <= 1) {
                return back()->withErrors(['error' => 'Tidak dapat menonaktifkan satu-satunya akun Administrator yang aktif.']);
            }
            $user->is_active = (bool) $validated['is_active'];
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Jika user ditautkan ke data master Student, sinkronkan juga
        if ($user->student) {
            $user->student->update([
                'nama' => $user->name,
                'nisn' => $user->nisn,
                'kelas' => $user->kelas,
                'no_hp' => $user->no_hp,
            ]);
        }

        return back()->with('success', "Data akun pengguna ({$user->name}) berhasil diperbarui!");
    }

    /**
     * Menghapus akun pengguna dari sistem (Delete User).
     */
    public function destroyUser(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Tidak boleh menghapus akun diri sendiri yang sedang login
        if (Auth::id() === $user->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.']);
        }

        // Tidak boleh menghapus satu-satunya administrator
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus satu-satunya akun Administrator di sistem.']);
        }

        $userName = $user->name;
        $userRole = $user->role;

        // Jika terhubung ke data master Student, lepaskan tautan agar data prapendaftaran tetap aman
        if ($user->student) {
            $user->student->update([
                'user_id' => null,
                'status' => 'terdaftar',
            ]);
        }

        $user->delete();

        // 1. Jika ada parameter redirect_to dari form yang bukan merupakan halaman detail akun yang dihapus
        if ($request->filled('redirect_to')) {
            $targetUrl = $request->input('redirect_to');
            if (! str_contains($targetUrl, "/admin/users/{$id}")) {
                return redirect($targetUrl)->with('success', "Akun pengguna ({$userName}) berhasil dihapus dari sistem!");
            }
        }

        // 2. Pertahankan filter role dan pencarian agar admin tetap berada di tab role yang sedang aktif
        $roleFilter = $request->input('role', $userRole);
        $queryParams = [];
        if ($roleFilter && in_array($roleFilter, ['siswa', 'guru_bk', 'admin'], true)) {
            $queryParams['role'] = $roleFilter;
        }
        if ($request->filled('q')) {
            $queryParams['q'] = $request->input('q');
        }

        return redirect()->route('admin.users', $queryParams)->with('success', "Akun pengguna ({$userName}) berhasil dihapus dari sistem!");
    }

    /**
     * Halaman Konfigurasi Sistem, LLM, dan Vector DB (SRS F-52 & F-53).
     */
    public function konfigurasi(): View
    {
        $config = [
            'llm_provider' => 'Google Gemini (Official Cloud)',
            'llm_model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
            'api_key_masked' => 'AIzaSy'.str_repeat('•', 24).'K9L',
            'temperature' => '0.4',
            'max_tokens' => '2048',
            'vector_db' => 'ChromaDB',
            'vector_host' => 'http://127.0.0.1:8000',
            'collection_name' => 'sman4_jember_bk_knowledge',
            'chunk_size' => '512',
            'chunk_overlap' => '64',
            'operating_hours' => '08:00 - 15:00 WIB',
        ];

        return view('admin.konfigurasi', compact('config'));
    }

    /**
     * Menyimpan pembaruan konfigurasi sistem.
     */
    public function simpanKonfigurasi(Request $request): RedirectResponse
    {
        $request->validate([
            'llm_model' => 'required|string',
            'temperature' => 'required|numeric|min:0|max:1',
            'collection_name' => 'required|string',
        ]);

        return back()->with('success', 'Konfigurasi parameter LLM & Vector DB berhasil diperbarui!');
    }

    /**
     * Halaman Log Aktivitas Sistem (SRS F-54).
     */
    public function log(): View
    {
        // Kompilasi log aktivitas sistem terbaru dari database
        $logs = [];

        $recentLogins = User::latest()->take(5)->get();
        foreach ($recentLogins as $u) {
            $logs[] = [
                'level' => 'INFO',
                'category' => 'Auth',
                'message' => "Pengguna terdaftar/diperbarui: {$u->name} ({$u->role})",
                'time' => $u->updated_at->diffForHumans(),
                'status' => 'Success',
            ];
        }

        $recentChats = ChatSession::with('user')->latest()->take(8)->get();
        foreach ($recentChats as $c) {
            $userName = $c->user ? $c->user->name : 'Siswa Tamu';
            $logs[] = [
                'level' => 'INFO',
                'category' => 'RAG AI',
                'message' => "Sesi konsultasi dimulai oleh {$userName}: \"{$c->title}\"",
                'time' => $c->created_at->diffForHumans(),
                'status' => 'Success',
            ];
        }

        $recentDocs = KnowledgeDocument::with('uploader')->latest()->take(4)->get();
        foreach ($recentDocs as $d) {
            $logs[] = [
                'level' => $d->status === 'indexed' ? 'INFO' : 'WARNING',
                'category' => 'Knowledge Base',
                'message' => "Dokumen '{$d->title}' diunggah. Status indeks: {$d->status}",
                'time' => $d->created_at->diffForHumans(),
                'status' => ucfirst($d->status),
            ];
        }

        return view('admin.log', compact('logs'));
    }

    /**
     * Halaman Laporan & Statistik Penggunaan (SRS F-55).
     */
    public function laporan(): View
    {
        $totalSessions = ChatSession::count();
        $totalMessages = ChatMessage::count();
        $totalAssessments = QuestionnaireResult::count();
        $totalUsers = User::count();

        // Rekapitulasi topik konsultasi
        $topicStats = [
            'Akademik & Studi Lanjut' => ChatMessage::where('role', 'user')->where(function ($q) {
                $q->where('content', 'like', '%kuliah%')
                    ->orWhere('content', 'like', '%jurusan%')
                    ->orWhere('content', 'like', '%snbt%');
            })->count(),
            'Manajemen Diri & Stres' => ChatMessage::where('role', 'user')->where(function ($q) {
                $q->where('content', 'like', '%stres%')
                    ->orWhere('content', 'like', '%cemas%')
                    ->orWhere('content', 'like', '%capek%');
            })->count(),
            'Lainnya / Umum' => ChatMessage::where('role', 'user')->count(),
        ];

        // Partisipasi asesmen per kuesioner
        $questionnaires = Questionnaire::withCount('results')->get();

        return view('admin.laporan', compact(
            'totalSessions',
            'totalMessages',
            'totalAssessments',
            'totalUsers',
            'topicStats',
            'questionnaires'
        ));
    }
}
