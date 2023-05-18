<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function rightQuestions()
    {
        return $this->belongsToMany(Question::class, 'right_answers', 'answer_id', 'question_id');
    }
}
