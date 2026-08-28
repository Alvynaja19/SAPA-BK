<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone', 'avatar_path', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Profil khusus siswa.
     */
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Profil khusus guru BK.
     */
    public function counselorProfile()
    {
        return $this->hasOne(CounselorProfile::class);
    }

    /**
     * Sesi percakapan konsultasi user.
     */
    public function chatSessions()
    {
        return $this->hasMany(ChatSession::class);
    }

    /**
     * Hasil tes kuesioner siswa.
     */
    public function results()
    {
        return $this->hasMany(QuestionnaireResult::class);
    }

    /**
     * E-book yang diunggah.
     */
    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'uploaded_by');
    }

    /**
     * Artikel yang ditulis.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * Dokumen knowledge base.
     */
    public function knowledgeDocuments()
    {
        return $this->hasMany(KnowledgeDocument::class, 'uploaded_by');
    }

    /**
     * Evaluasi chatbot oleh guru BK.
     */
    public function chatEvaluations()
    {
        return $this->hasMany(ChatEvaluation::class, 'evaluated_by');
    }
}

