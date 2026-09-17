<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',
        'kelas',
        'no_hp',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isGuruBk(): bool
    {
        return $this->role === 'guru_bk';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function chatSessions(): HasMany
    {
        return $this->hasMany(ChatSession::class);
    }

    public function counselingSessionsAsTeacher(): HasMany
    {
        return $this->hasMany(ChatSession::class, 'teacher_id');
    }

    public function counselingSessionsAsStudent(): HasMany
    {
        return $this->hasMany(ChatSession::class, 'user_id')->where('mode', 'guru_bk');
    }

    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'uploaded_by');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function questionnaireResults(): HasMany
    {
        return $this->hasMany(QuestionnaireResult::class);
    }

    public function knowledgeDocuments(): HasMany
    {
        return $this->hasMany(KnowledgeDocument::class, 'uploaded_by');
    }
}
