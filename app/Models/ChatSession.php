<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'title',
        'mode',
        'status',
        'started_at',
        'closed_at',
        'closed_by',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function isLiveChat(): bool
    {
        return $this->mode === 'guru_bk';
    }

    public function isAiChat(): bool
    {
        return $this->mode === 'ai' || empty($this->mode);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeForTeacher($query, int $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForStudent($query, int $studentId)
    {
        return $query->where('user_id', $studentId);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }
}
