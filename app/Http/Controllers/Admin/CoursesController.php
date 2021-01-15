<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\File;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;



use function PHPUnit\Framework\returnSelf;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check if the user has the ability to view the courses
        if(!hasAbility(['view_courses'])){
            //return error if the user doesn't have the ability to view courses
            abort(403);
        }
        //View all the courses if the user has the ability to view them 
        $coursesWithTeachersIDs =  Course::all();
        foreach($coursesWithTeachersIDs as $course){
            //get the users names and id by the global function
            $course['creator']      =   userDetails($course['creator'], "name&id");
        }
        return view('cp.courses.viewCourses')->with(['courses'=> $coursesWithTeachersIDs,'index' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check permissions
        if(!hasAbility(['add_courses'])){
            abort(403);
        }
        return view('cp.courses.createCourse');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
     * @param  \App\Models\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(course $course)
    {
        $currentUserID= session()->get('user');
        $course     = courseDetails($course['id'], "details");
        //get the quizzes for (Adding and editing levels) forms
/*         $quizzes =  Quiz::select('id', 'name', 'created_by')->orderByRaw(
                        "CASE WHEN created_by = '$currentUserID' THEN 1 ELSE 2 END ASC"
                    )->get();
        // preceed the quiz name by the quiz creator name
        foreach($quizzes as $quiz){
            $quiz['name'] = userDetails($quiz['created_by'], "name&id")['name'] . ": " . $quiz['name'];
        } */
        $quizzes =  Quiz::select('quizzes.id', 'quizzes.name', 'quizzes.created_by', 'users.first_name', 'users.surname')
                    ->leftJoin('users', function($join){
                        $join->on('quizzes.created_by', '=', 'users.id');
                    })
                    ->orderByRaw(
                        "CASE WHEN created_by = '$currentUserID' THEN 1 ELSE 2 END ASC"
                    )->get();
        // preceed the quiz name by the quiz creator name
        foreach($quizzes as $quiz){
            $quiz['name'] = $quiz['first_name'] ." " . $quiz['surname'] . ": " . $quiz['name'];
        }
        return view('cp.courses.showCourse', compact('course', 'quizzes')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(course $course)
    {
        //check if the user has the ability to edit any courses
        if (!hasAbility(['edit_courses'])){
            abort(403); 
        }
        return view('cp.courses.editCourse', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, course $course)
    {
        //check if the user has the ability to edit any courses
        if (!hasAbility(['edit_courses'])){
            abort(403);
        }
        ############################ <validation of the form fields> #########################
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
        //check if the user changed the course id to another one he doesn't have premissions to edit
        ######################## </validation of the form fields> ##############################

        //Get the model classes
        $file   = new File;
        ############################ <updating the course data> ################################
        $course->name           = $request->name;
        $course->description    = $request->description;
        $course->difficulty     = $request->difficulty;
        $course->state          = $request->state;
        $course->creator        = session()->get('user');
        
        ############################# </updating the course data> ###############################

        ########### <uploading & updating the course's image in case there's a new one>#########
        if($request->file()) {
            $fileName = time() . "_" . $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('courses/'.date("Y-M-d"),$fileName,'public_uploads');
            $file->name             = $fileName;
            $file->file_path        = '/public/uploads/courses/'.date("Y-M-d")."/$fileName";
            $file->type             = 'image';
            $file->user             = $request->session()->get('user');;
            $course->image          = '/public/uploads/courses/'.date("Y-M-d")."/$fileName";
            $file->save(); 
            $course->save(); 
            return ["success"=> "The course was edited successfully.", "image"=> $file->file_path];
        }
        ############################ </uploading & updating the course's image> #####################

        // in case there's no image
        $course->save(); 
        return ["success"=> "The course was edited successfully."];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(course $course)
    {
        //check if the user has the ability to delete any course
        if(!hasAbility(['delete_courses'])){
            abort(403);
        }
        
        $course->delete();
        return ["success"=> "The course was deleted successfully."];
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
                    'description'   => 'required|min:150|max:330',
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
                    'name.required' => 'Please enter the name of the course.',
                    'name.min' => 'The name should be at least 10 characters.',
                    'name.max' => 'The name should be maximum 60 characters.',
                    'description.required' => 'Please enter the description of the course.',
                    'description.min' => 'The description should be at least 150 characters.',
                    'description.max' => 'The description should maximum 330 characters.',
                    'difficulty.required' => 'Please select the difficulty of the course.',
                    'image.mimes' => 'The image format in not supported.',
                    'image.max' => "Only one image allowed and of maximum 200KB size.",
                ];
            break;
        }
        

    }
}
