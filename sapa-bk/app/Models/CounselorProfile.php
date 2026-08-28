<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounselorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'spesialisasi',
        'is_available',
        'last_seen_at',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
