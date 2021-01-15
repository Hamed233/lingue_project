<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\File;
use App\Models\Level;
use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LessonsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }
        return view('cp.lessons.createLesson', compact('course','level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, Level $level)
    {
        //check URL
        if($level->course_id != $course->id){
            abort(404);
        }
        //check permissions
        if(!hasAbility(['add_courses'])){
            abort(403);
        }
        ############################### <validation of the form fields> ############################
        $rules = $this->getRules('storeAndUpdate');
        $messages = $this->getMessages('storeAndUpdate');
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return $validator->errors();
        }

        //check if the user messed up with the difficulty select box
        if (!in_array($request->difficulty,["easy","difficult","intermediate"]) ){
            return ["error"=> "Choose the difficulty of the course."];
        }

        ##############################</validation of the form fields>############################
        
        ############################ <uploading & inserting the course's image>###################
        //Get the model classes
        $course = new Course;
        $file = new File;
        if($request->file()) {
            $fileName = time() . "_" . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('courses/'.date("Y-M-d"),$fileName,'public_uploads');
            $file->name             = $fileName;
            $file->file_path        = '/public/uploads/courses/'.date("Y-M-d")."/$fileName";
            $file->type             = 'image';
            $file->user             = $request->session()->get('user');;
            $file->save(); 
            $course->image          = '/public/uploads/courses/'.date("Y-M-d")."/$fileName";
        } 
        ######################### </uploading & inserting the course's image> #####################

        ############################## <inserting the course data> ################################
        $course->name           = $request->name;
        $course->description    = $request->description;
        $course->difficulty     = $request->difficulty;
        $course->creator        = session()->get('user');
        $course->save(); 
        ############################# </inserting the course data> #################################
        return ["success"=> "The course was created successfully."];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson, Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson, Course $course, Level $level)
    {
        if($level->course_id != $course->id){
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, Course $course, Level $level)
    {
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
                    'name'          => 'required|min:5|max:255',
                    'description'   => 'required|min:20|max:255',
                    'difficulty'    => 'required',
                    'image'       => 'mimes:jpg,bmp,png|max:200',
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
                    'title.required' => 'Please enter the name of the course.',
                    'title.min' => 'The name should be at least 10 characters.',
                    'title.max' => 'The name should be maximum 255 characters.',
                    'description.required' => 'Please enter the description of the course.',
                    'description.min' => 'The description should be at least 20 characters.',
                    'description.max' => 'The description should maximum 255 characters.',
                    'difficulty.required' => 'Please select the difficulty of the course.',
                    'image.mimes' => 'The image format in not supported.',
                    'image.max' => "Only one image allowed and of maximum 200KB size.",
                ];
            break;
        }
        
        
    }
}
