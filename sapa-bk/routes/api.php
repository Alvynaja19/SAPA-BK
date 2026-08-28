<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes Internal — /api/*
| Semua route ini memerlukan auth session (bukan token Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Buat sesi percakapan baru
    Route::post('/chat/session', [ChatController::class, 'newSession'])
        ->name('api.chat.session');

    // Kirim pesan ke chatbot, dapatkan respons
    Route::post('/chat', [ChatController::class, 'send'])
        ->name('api.chat.send');

    // Ambil riwayat sesi tertentu
    Route::get('/chat/history/{id}', [ChatController::class, 'history'])
        ->name('api.chat.history');

    // Request Live Chat (Siswa -> Guru BK)
    Route::post('/chat/{id}/request-live', [ChatController::class, 'requestLiveChat'])
        ->name('api.chat.request_live');

    // Status & Polling Sesi (Siswa)
    Route::get('/chat/{id}/status', [ChatController::class, 'sessionStatus'])
        ->name('api.chat.status');

    // Live Chat Endpoint Guru BK
    Route::middleware('role:guru_bk,admin')->group(function () {
        Route::get('/bk/live-chat/queue', [\App\Http\Controllers\CounselorController::class, 'liveChatQueue'])
            ->name('api.bk.live_chat.queue');
        Route::post('/bk/live-chat/{id}/accept', [\App\Http\Controllers\CounselorController::class, 'liveChatAccept'])
            ->name('api.bk.live_chat.accept');
        Route::post('/bk/live-chat/{id}/send', [\App\Http\Controllers\CounselorController::class, 'liveChatSend'])
            ->name('api.bk.live_chat.send');
        Route::post('/bk/live-chat/{id}/close', [\App\Http\Controllers\CounselorController::class, 'liveChatClose'])
            ->name('api.bk.live_chat.close');
    });
});
