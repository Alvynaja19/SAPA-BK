<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatEvaluation extends Model
{
    protected $fillable = [
        'message_id',
        'evaluated_by',
        'rating',
        'note',
    ];

    public function message()
    {
        return $this->belongsTo(ChatMessage::class, 'message_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
