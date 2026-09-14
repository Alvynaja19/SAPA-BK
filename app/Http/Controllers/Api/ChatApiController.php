<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatApiController extends Controller
{
    /**
     * Membuat sesi konsultasi baru.
     */
    public function createSession(Request $request): JsonResponse
    {
        $user = Auth::user() ?? $request->user();
        $mode = ($request->input('mode') === 'live' || $request->input('mode') === 'guru_bk') ? 'guru_bk' : 'ai';
        $defaultTitle = ($mode === 'guru_bk')
            ? 'Konsultasi Guru BK '.now()->format('d M H:i')
            : 'Sesi Chatbot AI '.now()->format('d M H:i');

        $session = ChatSession::create([
            'user_id' => $user?->id,
            'title' => $request->input('title', $defaultTitle),
            'mode' => $mode,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi percakapan berhasil dibuat.',
            'data' => $session,
        ], 201);
    }

    /**
     * Mengambil riwayat percakapan suatu sesi.
     */
    public function history(int $id): JsonResponse
    {
        $session = ChatSession::with('messages')->find($id);

        if (! $session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi percakapan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    /**
     * Mengirim pesan dan menerima respons dari asisten AI atau Konselor Guru BK.
     */
    public function sendMessage(Request $request, ChatService $chatService): JsonResponse
    {
        $request->validate([
            'session_id' => 'nullable|exists:chat_sessions,id',
            'message' => 'required|string|max:2000',
            'mode' => 'nullable|string|in:ai,live,guru_bk',
        ]);

        $user = Auth::user() ?? $request->user();
        $sessionId = $request->input('session_id') ? (int) $request->input('session_id') : null;
        $messageText = $request->input('message');
        $mode = $request->input('mode', 'ai');

        $result = $chatService->processMessage($messageText, $sessionId, $user, $mode);

        return response()->json([
            'success' => true,
            'session_id' => $result['session']->id,
            'mode' => $result['session']->mode,
            'user_message' => $result['user_message'],
            'assistant_message' => $result['assistant_message'],
        ]);
    }

    /**
     * Menghapus arsip percakapan khusus Chatbot AI.
     */
    public function deleteSession(Request $request, int $id): JsonResponse
    {
        $user = Auth::user() ?? $request->user();
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak valid atau telah berakhir.',
            ], 401);
        }

        $session = ChatSession::where('user_id', $user->id)->find($id);

        if (! $session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi percakapan tidak ditemukan.',
            ], 404);
        }

        // Proteksi: Khusus Chatbot AI saja yang dapat dihapus siswa
        if ($session->mode === 'guru_bk') {
            return response()->json([
                'success' => false,
                'message' => 'Arsip Live Chat Guru BK merupakan rekaman resmi bimbingan konseling dan tidak dapat dihapus.',
            ], 403);
        }

        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Arsip percakapan Chatbot AI berhasil dihapus.',
        ]);
    }
}
