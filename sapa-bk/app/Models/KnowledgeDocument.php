<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'status',
        'indexed_at',
        'uploaded_by',
    ];

    protected $casts = [
        'indexed_at' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
