<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Full chatbot page — /chat
     */
    public function index()
    {
        $sessions = ChatSession::where('user_id', auth()->id())
                               ->latest()
                               ->get();
        return view('student.chat', compact('sessions'));
    }

    /**
     * Sesi percakapan spesifik — /chat/{session_id}
     */
    public function show(int $sessionId)
    {
        $session  = ChatSession::where('user_id', auth()->id())
                               ->with('messages')
                               ->findOrFail($sessionId);
        $sessions = ChatSession::where('user_id', auth()->id())->latest()->get();
        return view('student.chat', compact('session', 'sessions'));
    }

    /**
     * Buat sesi baru — POST /api/chat/session
     */
    public function newSession(Request $request)
    {
        $session = ChatSession::create([
            'user_id' => auth()->id(),
            'title'   => 'Konsultasi ' . now()->format('d M Y, H:i'),
        ]);

        return response()->json(['session_id' => $session->id]);
    }

    /**
     * Kirim pesan & dapatkan respons AI BK pintar.
     */
    public function send(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
            'message'    => 'required|string|max:2000',
        ]);

        // Pastikan sesi milik user yang sedang login
        $session = ChatSession::where('id', $request->session_id)
                              ->where('user_id', auth()->id())
                              ->firstOrFail();

        // Update judul sesi jika ini pesan pertama
        if ($session->messages()->count() === 0) {
            $session->update([
                'title' => Str::limit($request->message, 30),
            ]);
        }

        // Simpan pesan user
        ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'user',
            'content'    => $request->message,
        ]);

        // --- INTELLIGENT BK RESPONSE GENERATOR ---
        $response = $this->generateBkResponse($request->message, auth()->user()->name);

        $assistantMessage = ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'assistant',
            'content'    => $response['answer'],
            'metadata'   => json_encode([
                'sources'             => $response['sources'],
                'recommended_ebooks'  => $response['recommended_ebooks'],
            ]),
        ]);

        return response()->json([
            'answer'             => $response['answer'],
            'sources'            => $response['sources'],
            'recommended_ebooks' => $response['recommended_ebooks'],
            'message_id'         => $assistantMessage->id,
        ]);
    }

    /**
     * Generator Jawaban BK berbasis pengetahuan & empati.
     */
    private function generateBkResponse(string $message, string $userName): array
    {
        $msgLower = strtolower($message);
        $sources = ['Panduan Resmi BK SMAN 4 Jember', 'Modul Psikologi Perkembangan Remaja'];
        $recommendedEbooks = [];

        // 1. Topik Jurusan / Kuliah / UTBK / SNBP
        if (Str::contains($msgLower, ['jurusan', 'kuliah', 'ptn', 'utbk', 'snbp', 'snbt', 'karir', 'cita-cita'])) {
            $answer = "Halo {$userName}! Memilih jurusan kuliah adalah langkah penting bagi siswa SMAN 4 Jember. Berikut beberapa tips dari Guru BK:\n\n"
                    . "1. **Kenali Minat & Bakat**: Kelompokkan mata pelajaran favoritmu dan kecenderungan gaya berkerjamu.\n"
                    . "2. **Riset Daya Tampung & Prospek**: Pelajari rasio keketatan jurusan impian di PTN tujuan.\n"
                    . "3. **Evaluasi Nilai Rapor (SNBP)**: Analisis konsistensi grafik nilai dari semester 1 hingga 5.\n"
                    . "4. **Konsultasikan dengan Guru BK**: Kamu bisa menjadwalkan sesi diskusikan pilihan jurusan bersama Tim Konselor SMAN 4 Jember.\n\n"
                    . "Ada universitas atau jurusan tertentu yang sedang kamu pertimbangkan?";
            $recommendedEbooks = ['Panduan Memilih Jurusan PTN 2026', 'Strategi Sukses SNBP & UTBK-SNBT'];
        }
        // 2. Topik Stres / Cemas / Takut / Overthinking
        elseif (Str::contains($msgLower, ['stres', 'cemas', 'takut', 'sedih', 'pusing', 'capek', 'lelah', 'overthinking', 'mental', 'tekanan'])) {
            $answer = "Halo {$userName}, terima kasih sudah berbagi. Perasaan lelah atau cemas adalah hal yang wajar dialami siswa. Ingatlah bahwa kamu tidak sendirian di SMAN 4 Jember.\n\n"
                    . "Langkah awal yang bisa kamu coba saat ini:\n"
                    . "• **Tarik Napas Dalam (Metode 4-7-8)**: Tarik napas 4 detik, tahan 7 detik, lalu hembuskan perlahan 8 detik.\n"
                    . "• **Beri Jeda Istirahat**: Rehat sejenak dari gadget dan tugas selama 15-30 menit.\n"
                    . "• **Ceritakan pada Konselor**: Jika terasa semakin berat, pintu ruang BK SMAN 4 Jember selalu terbuka hangat untukmu.\n\n"
                    . "Apakah ada masalah khusus di sekolah atau rumah yang membuatmu merasa terbebani?";
            $recommendedEbooks = ['Manajemen Stres & Kesehatan Mental Remaja'];
        }
        // 3. Topik Belajar / Konsentrasi / Malas / Waktu
        elseif (Str::contains($msgLower, ['belajar', 'konsentrasi', 'fokus', 'malas', 'waktu', 'jadwal', 'nilai', 'tugas', 'ujian'])) {
            $answer = "Halo {$userName}! Untuk meningkatkan efektivitas belajar dan konsentrasi di SMAN 4 Jember, cobalah strategi berikut:\n\n"
                    . "1. **Metode Pomodoro**: Belajar fokus 25 menit, lalu istirahat singkat 5 menit. Ulangi 4 kali.\n"
                    . "2. **Skala Prioritas (Matriks Eisenhower)**: Kerjakan tugas yang *Penting & Mendesak* terlebih dahulu.\n"
                    . "3. **Active Recall**: Setelah membaca materi, cobalah jelaskan kembali tanpa melihat catatan.\n"
                    . "4. **Jauhkan Distraksi**: Pindahkan HP ke luar jangkauan saat jam belajar fokus.\n\n"
                    . "Mata pelajaran apa yang paling ingin kamu tingkatkan cara belajarnya saat ini?";
            $recommendedEbooks = ['Tips & Trik Efektif Belajar Tanpa Stres'];
        }
        // 4. Default / General BK Response
        else {
            $answer = "Halo {$userName}! Saya adalah Asisten Digital BK SMAN 4 Jember.\n\n"
                    . "Saya siap membantu menjawab pertanyaan seputar:\n"
                    . "• 🎓 **Perencanaan Karir & Jurusan Kuliah**\n"
                    . "• 💚 **Kesehatan Mental & Pengelolaan Stres**\n"
                    . "• 📚 **Tips & Strategi Belajar Efektif**\n"
                    . "• 📝 **Informasi Tes Minat Bakat & Layanan BK**\n\n"
                    . "Ada hal seputar sekolah atau pengembangan diri yang ingin kamu tanyakan hari ini?";
        }

        return [
            'answer'             => $answer,
            'sources'            => $sources,
            'recommended_ebooks' => $recommendedEbooks,
        ];
    }

    /**
     * Ambil riwayat sesi tertentu — GET /api/chat/history/{id}
     */
    public function history(int $sessionId)
    {
        $session = ChatSession::where('user_id', auth()->id())
                              ->with('messages')
                              ->findOrFail($sessionId);

        return response()->json($session->messages);
    }
}
