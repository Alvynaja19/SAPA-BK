<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireResult extends Model
{
    protected $fillable = [
        'questionnaire_id',
        'user_id',
        'answers',
        'score',
    ];

    protected $casts = [
        'answers' => 'array',
        'score'   => 'integer',
    ];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
