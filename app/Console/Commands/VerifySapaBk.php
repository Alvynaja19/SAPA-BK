<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\ChatApiController;
use App\Models\Article;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Ebook;
use App\Models\Faq;
use App\Models\Questionnaire;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VerifySapaBk extends Command
{
    protected $signature = 'sapabk:verify';

    protected $description = 'Verifikasi menyeluruh sistem SAPA BK SMA Negeri 4 Jember';

    public function handle()
    {
        $this->info('==========================================');
        $this->info('🔍 MEMULAI VERIFIKASI SISTEM SAPA BK SMAN 4');
        $this->info('==========================================');

        // 1. Data Verifikasi
        $userCount = User::count();
        $ebookCount = Ebook::count();
        $articleCount = Article::count();
        $questionnaireCount = Questionnaire::count();

        $this->line("• Total Pengguna Terdaftar: <fg=green>$userCount</>");
        $this->line("• Total E-Book Terbit: <fg=green>$ebookCount</>");
        $this->line("• Total Artikel Edukasi: <fg=green>$articleCount</>");
        $this->line("• Total Kuesioner Asesmen: <fg=green>$questionnaireCount</>");

        // 2. Verifikasi Akun Pengguna Kunci
        $siswa = User::where('email', 'siswa@sman4jember.sch.id')->first();
        $guru = User::where('email', 'gurubk@sman4jember.sch.id')->first();
        $admin = User::where('email', 'admin@sman4jember.sch.id')->first();

        if ($siswa && $guru && $admin) {
            $this->info('✓ Seluruh Akun Demo (Siswa, Guru BK, Admin) Berhasil Divalidasi.');
        } else {
            $this->error('✗ Akun demo belum lengkap.');

            return 1;
        }

        // 3. Verifikasi Rendering Blade Views
        $viewsToTest = [
            'frontend.index' => ['ebooks' => Ebook::where('is_public', true)->take(4)->get(), 'articles' => Article::take(3)->get(), 'faqs' => Faq::take(4)->get()],
            'frontend.about' => [],
            'frontend.ebooks' => ['ebooks' => Ebook::where('is_public', true)->paginate(9)],
            'frontend.articles' => ['articles' => Article::paginate(9)],
            'frontend.faq' => ['faqs' => Faq::paginate(10)],
            'auth.login' => [],
            'auth.register' => [],
        ];

        foreach ($viewsToTest as $viewName => $data) {
            try {
                View::make($viewName, $data)->render();
                $this->line("  ✓ View [$viewName] ter-render dengan sukses.");
            } catch (\Throwable $e) {
                $this->error("  ✗ Gagal render [$viewName]: ".$e->getMessage());

                return 1;
            }
        }

        // 4. Verifikasi Siswa Dashboard & Chat View
        auth()->login($siswa);
        try {
            View::make('siswa.dashboard', [
                'user' => $siswa,
                'totalSessions' => 1,
                'recentSessions' => ChatSession::take(5)->get(),
                'questionnaires' => Questionnaire::all(),
                'ebooks' => Ebook::take(4)->get(),
            ])->render();
            $this->line('  ✓ View [siswa.dashboard] ter-render dengan sukses.');

            View::make('siswa.chat', [
                'sessions' => ChatSession::where('user_id', $siswa->id)->get(),
                'currentSession' => ChatSession::where('user_id', $siswa->id)->first(),
            ])->render();
            $this->line('  ✓ View [siswa.chat] ter-render dengan sukses.');
        } catch (\Throwable $e) {
            $this->error('  ✗ Gagal render view siswa: '.$e->getMessage());

            return 1;
        }

        // 5. Verifikasi Guru BK Dashboard
        auth()->login($guru);
        try {
            View::make('bk.dashboard', [
                'totalSiswa' => User::where('role', 'siswa')->count(),
                'totalPercakapan' => ChatSession::count(),
                'totalEbook' => Ebook::count(),
                'totalArtikel' => Article::count(),
                'recentPercakapan' => ChatSession::with('user')->latest()->take(5)->get(),
                'pendingEvaluations' => ChatMessage::where('role', 'assistant')->doesntHave('evaluation')->latest()->take(5)->get(),
            ])->render();
            $this->line('  ✓ View [bk.dashboard] ter-render dengan sukses.');
        } catch (\Throwable $e) {
            $this->error('  ✗ Gagal render view Guru BK: '.$e->getMessage());

            return 1;
        }

        // 6. Verifikasi Admin Dashboard
        auth()->login($admin);
        try {
            View::make('admin.dashboard', [
                'totalUsers' => User::count(),
                'totalSiswa' => User::where('role', 'siswa')->count(),
                'totalGuruBk' => User::where('role', 'guru_bk')->count(),
                'totalSessions' => ChatSession::count(),
                'recentUsers' => User::latest()->take(5)->get(),
            ])->render();
            $this->line('  ✓ View [admin.dashboard] ter-render dengan sukses.');
        } catch (\Throwable $e) {
            $this->error('  ✗ Gagal render view Admin: '.$e->getMessage());

            return 1;
        }

        // 7. Verifikasi API Chatbot & RAG Mock Engine
        auth()->login($siswa);
        $request = new Request([
            'message' => 'Halo Bu Guru, saya bingung memilih jurusan kuliah untuk SNBP dan kedokteran',
        ]);
        $chatController = new ChatApiController;
        $chatService = new ChatService;
        $response = $chatController->sendMessage($request, $chatService);
        $resData = json_decode($response->getContent(), true);

        if ($resData && isset($resData['success']) && $resData['success'] === true) {
            $this->info('✓ AI RAG Chatbot API Berhasil Merespons!');
            $this->line('  • Respon Cuplikan: '.substr($resData['assistant_message']['content'], 0, 80).'...');
            if (! empty($resData['assistant_message']['metadata']['sources'])) {
                $this->line('  • Sumber RAG Terkait: '.implode(', ', $resData['assistant_message']['metadata']['sources']));
            }
        } else {
            $this->error('✗ Chat API gagal mengembalikan respon yang valid.');

            return 1;
        }

        $this->info('==========================================');
        $this->info('🎉 SELURUH SISTEM SAPA BK SMAN 4 JEMBER TELAH TERVERIFIKASI SEMPURNA!');
        $this->info('==========================================');

        return 0;
    }
}
