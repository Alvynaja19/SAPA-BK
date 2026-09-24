<?php

use App\Models\ChatSession;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.session.{sessionId}', function ($user, $sessionId) {
    $session = ChatSession::find($sessionId);
    if (! $session) {
        return false;
    }

    return (int) $user->id === (int) $session->user_id
        || (int) $user->id === (int) $session->teacher_id
        || $user->isGuruBk();
});
