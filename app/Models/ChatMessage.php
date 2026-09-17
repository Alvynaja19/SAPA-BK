<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'sender_id',
        'role',
        'content',
        'is_read',
        'read_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function evaluation(): HasOne
    {
        return $this->hasOne(ChatEvaluation::class, 'message_id');
    }
}
