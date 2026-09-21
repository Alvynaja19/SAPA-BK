<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SAPA BK (SMA Negeri 4 Jember)
|--------------------------------------------------------------------------
*/

// Rute Publik (Tamu & Umum)
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/tentang', [FrontendController::class, 'about'])->name('about');
Route::get('/ebook', [FrontendController::class, 'ebooks'])->name('ebook.index');
Route::get('/ebook/{id}', [FrontendController::class, 'ebookDetail'])->name('ebook.detail')->whereNumber('id');
Route::get('/artikel', [FrontendController::class, 'articles'])->name('article.index');
Route::get('/artikel/{slug}', [FrontendController::class, 'articleDetail'])->name('article.detail');
Route::get('/faq', [FrontendController::class, 'faqs'])->name('faq');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Aktivasi Akun Siswa (Pre-registered via NIS/NISN & Email OTP)
    Route::get('/aktivasi', [AuthController::class, 'showAktivasiForm'])->name('aktivasi');
    Route::post('/aktivasi/lookup', [AuthController::class, 'aktivasiLookup'])->name('aktivasi.lookup');
    Route::post('/aktivasi/send-otp', [AuthController::class, 'aktivasiSendOtp'])->name('aktivasi.send-otp');
    Route::post('/aktivasi/verify-otp', [AuthController::class, 'aktivasiVerifyOtp'])->name('aktivasi.verify-otp');
    Route::post('/aktivasi/reset', [AuthController::class, 'aktivasiReset'])->name('aktivasi.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Rute Siswa
    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/chat', [SiswaController::class, 'chat'])->name('siswa.chat');
        Route::get('/chat/{session_id}', [SiswaController::class, 'chat'])->name('siswa.chat.session');
        Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
        Route::delete('/riwayat/{id}', [SiswaController::class, 'hapusSesi'])->name('siswa.riwayat.delete');
        Route::get('/ebook/akses', [SiswaController::class, 'ebookAkses'])->name('siswa.ebook');
        Route::get('/tes', [SiswaController::class, 'tes'])->name('siswa.tes');
        Route::get('/tes/{id}', [SiswaController::class, 'isiTes'])->name('siswa.tes.isi');
        Route::post('/tes/{id}', [SiswaController::class, 'simpanTes'])->name('siswa.tes.simpan');
        Route::get('/tes/{id}/hasil', [SiswaController::class, 'hasilTes'])->name('siswa.tes.hasil');
    });

    // API Chat & Live Chat (dengan otentikasi sesi penuh)
    Route::prefix('api/chat')->group(function () {
        Route::get('/teachers', [ChatApiController::class, 'teachers'])->name('api.chat.teachers');
        Route::get('/live/active-session', [ChatApiController::class, 'activeLiveSession'])->name('api.chat.live.active');
        Route::post('/', [ChatApiController::class, 'sendMessage'])->name('api.chat.send');
        Route::post('/session', [ChatApiController::class, 'createSession'])->name('api.chat.session');
        Route::get('/history/{id}', [ChatApiController::class, 'history'])->name('api.chat.history');
        Route::delete('/session/{id}', [ChatApiController::class, 'deleteSession'])->name('api.chat.session.delete');
    });

    // Rute Guru BK
    Route::middleware('role:guru_bk')->prefix('bk')->as('bk.')->group(function () {
        Route::get('/dashboard', [GuruBkController::class, 'dashboard'])->name('dashboard');
        Route::get('/siswa', [GuruBkController::class, 'siswa'])->name('siswa');
        Route::get('/percakapan', [GuruBkController::class, 'percakapan'])->name('percakapan');
        Route::get('/percakapan/{id}', [GuruBkController::class, 'detailPercakapan'])->name('percakapan.detail');
        Route::get('/live-chat', [GuruBkController::class, 'liveChat'])->name('live-chat');
        Route::get('/live-chat/api/queue', [GuruBkController::class, 'liveChatQueue'])->name('live-chat.queue');
        Route::get('/live-chat/api/session/{sessionId}/messages', [GuruBkController::class, 'liveChatMessages'])->name('live-chat.messages');
        Route::post('/live-chat/api/session/{sessionId}/send', [GuruBkController::class, 'sendLiveChatMessage'])->name('live-chat.send');
        Route::post('/live-chat/api/session/{sessionId}/close', [GuruBkController::class, 'closeLiveChatSession'])->name('live-chat.close');

        Route::get('/ebook', [GuruBkController::class, 'ebook'])->name('ebook');
        Route::post('/ebook', [GuruBkController::class, 'simpanEbook'])->name('ebook.store');
        Route::delete('/ebook/{id}', [GuruBkController::class, 'hapusEbook'])->name('ebook.destroy');

        Route::get('/artikel', [GuruBkController::class, 'artikel'])->name('artikel');
        Route::post('/artikel', [GuruBkController::class, 'simpanArtikel'])->name('artikel.store');
        Route::post('/artikel/sync-rss', [GuruBkController::class, 'syncRssArtikel'])->name('artikel.sync-rss');
        Route::delete('/artikel/{id}', [GuruBkController::class, 'hapusArtikel'])->name('artikel.destroy');

        Route::get('/knowledge-base', [GuruBkController::class, 'knowledgeBase'])->name('knowledge');
        Route::post('/knowledge-base', [GuruBkController::class, 'simpanKnowledge'])->name('knowledge.store');

        Route::get('/tes', [GuruBkController::class, 'tes'])->name('tes');
        Route::post('/tes', [GuruBkController::class, 'simpanTes'])->name('tes.store');
        Route::put('/tes/{id}', [GuruBkController::class, 'updateTes'])->name('tes.update');
        Route::delete('/tes/{id}', [GuruBkController::class, 'hapusTes'])->name('tes.destroy');
        Route::get('/tes/{id}/hasil', [GuruBkController::class, 'hasilTes'])->name('tes.hasil');
        Route::get('/tes/{id}/soal', [GuruBkController::class, 'kelolaSoal'])->name('tes.soal');
        Route::post('/tes/{id}/soal', [GuruBkController::class, 'simpanSoal'])->name('tes.soal.store');
        Route::put('/tes/{id}/soal/{soalId}', [GuruBkController::class, 'updateSoal'])->name('tes.soal.update');
        Route::delete('/tes/{id}/soal/{soalId}', [GuruBkController::class, 'hapusSoal'])->name('tes.soal.destroy');

        Route::get('/evaluasi', [GuruBkController::class, 'evaluasi'])->name('evaluasi');
        Route::post('/evaluasi/{messageId}', [GuruBkController::class, 'simpanEvaluasi'])->name('evaluasi.store');

        Route::get('/faq', [GuruBkController::class, 'faq'])->name('faq');
        Route::post('/faq', [GuruBkController::class, 'simpanFaq'])->name('faq.store');
    });

    // Rute Administrator
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('users.detail');
        Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
        Route::get('/siswa/template', [AdminController::class, 'downloadSiswaTemplate'])->name('siswa.template');
        Route::post('/siswa/import', [AdminController::class, 'importSiswa'])->name('siswa.import');
        Route::get('/konfigurasi', [AdminController::class, 'konfigurasi'])->name('konfigurasi');
        Route::post('/konfigurasi', [AdminController::class, 'simpanKonfigurasi'])->name('konfigurasi.store');
        Route::get('/log', [AdminController::class, 'log'])->name('log');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    });
});
