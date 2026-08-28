<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Article;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;
use App\Models\CounselorProfile;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Dashboard siswa — /dashboard
     */
    public function dashboard()
    {
        $user = auth()->user()->load('studentProfile');

        // Status Jam Kerja & Konselor
        $nowWib = Carbon::now('Asia/Jakarta');
        $isWorkingHours = ($nowWib->hour >= 8 && $nowWib->hour < 15);
        $activeCounselor = CounselorProfile::where('is_available', true)->with('user')->first();

        // Sesi aktif live chat siswa jika ada
        $activeLiveSession = ChatSession::where('user_id', $user->id)
            ->where('type', 'human')
            ->whereIn('status', ['waiting', 'active'])
            ->latest()
            ->first();

        // Percakapan terkini
        $recentSessions = ChatSession::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // Hasil tes minat bakat / asesmen terakhir
        $latestTestResult = QuestionnaireResult::where('user_id', $user->id)
            ->with('questionnaire')
            ->latest()
            ->first();

        // Rekomendasi E-book & Artikel untuk Siswa
        $ebooks = Ebook::where('is_public', true)->latest()->take(3)->get();
        $articles = Article::where('is_published', true)->latest()->take(3)->get();
        $totalTesTersedia = Questionnaire::where('is_active', true)->count();

        // Stats Tambahan Aktivitas Siswa
        $totalKonsultasiSaya = ChatSession::where('user_id', $user->id)->count();
        $totalTesDiselesaikan = QuestionnaireResult::where('user_id', $user->id)->count();
        $totalEbookTersedia = Ebook::where('is_public', true)->count();

        return view('student.dashboard', compact(
            'user',
            'isWorkingHours',
            'activeCounselor',
            'activeLiveSession',
            'recentSessions',
            'latestTestResult',
            'ebooks',
            'articles',
            'totalTesTersedia',
            'totalKonsultasiSaya',
            'totalTesDiselesaikan',
            'totalEbookTersedia'
        ));
    }

    /**
     * Riwayat konsultasi — /riwayat
     */
    public function riwayat(Request $request)
    {
        $user     = auth()->user();
        $sessions = ChatSession::where('user_id', $user->id)->latest()->paginate(10);
        return view('student.riwayat', compact('sessions'));
    }

    /**
     * Akses e-book siswa — /ebook/akses
     */
    public function ebook(Request $request)
    {
        $query = Ebook::query();
        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }
        $ebooks = $query->latest()->paginate(12);
        return view('student.ebook', compact('ebooks'));
    }

    /**
     * Daftar tes — /tes
     */
    public function tes()
    {
        $questionnaires = Questionnaire::where('is_active', true)->get();
        $results        = QuestionnaireResult::where('user_id', auth()->id())
                                              ->pluck('questionnaire_id');
        return view('student.tes', compact('questionnaires', 'results'));
    }

    /**
     * Form isi tes — /tes/{id}
     */
    public function tesDetail(int $id)
    {
        $questionnaire = Questionnaire::where('is_active', true)->findOrFail($id);
        return view('student.tes-detail', compact('questionnaire'));
    }

    /**
     * Hasil tes — /tes/{id}/hasil
     */
    public function tesHasil(int $id)
    {
        $result = QuestionnaireResult::where('user_id', auth()->id())
                                      ->where('questionnaire_id', $id)
                                      ->with('questionnaire')
                                      ->firstOrFail();
        return view('student.tes-hasil', compact('result'));
    }

    /**
     * Profil siswa — /profil
     */
    public function profil()
    {
        $user = auth()->user();
        return view('student.profil', compact('user'));
    }

    /**
     * Update profil siswa
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update($request->only('name', 'email'));
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
