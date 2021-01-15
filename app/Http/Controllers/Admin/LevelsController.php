<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }
        //check permissions
        if(!hasAbility(['edit_courses'])){
            abort(403);
        }
        ############################### <validation of the form fields> ############################
        $rules = $this->getRules('storeAndUpdate');
        $messages = $this->getMessages('storeAndUpdate');
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return $validator->errors();
        }
        ##############################</validation of the form fields>############################

        ############################## <inserting the level data> ################################
        $level = new Level;
        $level->name            = $request->name;
        $level->course_id       = $request->course;
        $level->unlocked_by     = $request->lock_state;
        $level->exam            = $request->exam;
        $level->save();
        
        ############################# </inserting the course data> #################################
        return ["success"=> "The level was added successfully.", "last_insert_id"=> $level->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course,Level $level)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course,Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course , Level $level)
    {
        //check URL
        if($level->course_id != $course->id){
            abort(404);
        }
        //check permissions
        if(!hasAbility(['edit_courses'])){
            abort(403);
        }
        ############################### <validation of the form fields> ############################
        $rules = $this->getRules('storeAndUpdate');
        $messages = $this->getMessages('storeAndUpdate');
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return $validator->errors();
        }
        ##############################</validation of the form fields>############################

        ############################## <inserting the level data> ################################
        $level->name            = $request->name;
        $level->course_id       = $request->course;
        $level->unlocked_by     = $request->lock_state;
        $level->exam            = $request->exam;
        $level->save();
        
        ############################# </inserting the course data> #################################
        return ["success"=> "The level was updated successfully.", "level_id"=> $level->id];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level, Course $course)
    {
        //check URL
        if($level->course_id != $course->id){
            abort(404);
        }
    }

        /**
     * Get the forms validation rules by method name.
     *
     * @param    $methodName
     * @return \Illuminate\Http\Response
     */
    protected function getRules($methodName){
        switch($methodName){
            case "storeAndUpdate":
                $rules = [
                    'name'          => 'required|min:5|max:60',
                    'lock_state'    => 'required',
                    'course'    => 'required',
                    'exam'    => 'required',
                ];
                return $rules;
            break;
        }
        
    }

    /**
     * Get the forms validation messages by method name.
     *
     * @param    $methodName
     * @return \Illuminate\Http\Response
     */
    protected function getMessages($methodName){
        switch($methodName){
            case "storeAndUpdate":
                return $messages = [
                    'name.required' => 'Please enter the name of the course.',
                    'name.min' => 'The name should be at least 10 characters.',
                    'name.max' => 'The name should be maximum 60 characters.',
                    'lock_state.required' => 'Please select the lock state of the level.',
                    'exam.required' => 'Please select the exam state of the level.',
                    'course.required' => 'There was a problem identifying the course.',

                ];
            break;
        }
        

    }
}
