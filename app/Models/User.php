<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'surname',
        'password',
        'email',
        'role',
        'timezone',
        'avatar',
        'language',
        'learning_time',
        'suspended',
        'availability'
    ];
    public function roles(){
        return $this->belongsTo(Role::class,'role','id');
    } 
    public function quizzes(){
        return $this->hasMany(Quiz::class,'created_by','id');
    } 
}
