<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResult;

class StudentController extends Controller
{
    /**
     * Dashboard siswa — /dashboard
     */
    public function dashboard()
    {
        $user          = auth()->user();
        $sessions      = ChatSession::where('user_id', $user->id)->latest()->take(3)->get();
        $ebooks        = Ebook::where('is_public', true)->latest()->take(4)->get();
        $questionnaires = Questionnaire::where('is_active', true)->latest()->take(3)->get();

        return view('student.dashboard', compact('user', 'sessions', 'ebooks', 'questionnaires'));
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
