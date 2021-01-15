<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class CpIndex extends Controller
{
    public function getStatistics(){
        return view('cp.index')->with(
            [
                'coursesCount'  => Course::all()->count(),
                'studentsCount' => User::where('role' , '=', '1')->count(),
                'lessonsCount'  => Lesson::all()->count()
            ]);

    }
}
