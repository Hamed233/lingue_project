<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    Protected $table = "quizzes";

    public function creator(){
        return $this->belongsTo('users', 'created_by', 'id');
    }
}
