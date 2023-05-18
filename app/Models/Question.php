<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

//    public function right_answer()
//    {
//        return $this->hasOne(RightAnswer::class);
//    }

    public function rightAnswers()
    {
        return $this->belongsToMany(Answer::class, 'right_answers', 'question_id', 'answer_id');
    }
}
