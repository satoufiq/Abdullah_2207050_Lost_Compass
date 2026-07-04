<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer_text',
        'role_impact',
        'trait_impact',
        'allegiance_impact'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
