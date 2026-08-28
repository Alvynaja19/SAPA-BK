<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'role',
        'content',
        'metadata',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }

    public function evaluations()
    {
        return $this->hasMany(ChatEvaluation::class, 'message_id');
    }
}
