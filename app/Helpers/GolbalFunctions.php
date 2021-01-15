<?php
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use App\Models\Level;
use App\Models\Lesson;
use Ramsey\Uuid\Type\Integer;

/**
     * Check the current user's ability to access specific things.
     *
     * @param    $askedPermissions
     * @return array with two elements (name and id)
     */
    function hasAbility($askedPermissions){
        //get the current user's role permisions by 
        $user = User::leftJoin('roles', function($join){
            $join->on('users.role', '=', 'roles.id');
        })->findOrFail(session()->get('user'));
        $role_permissions= json_decode($user->permissions);

        //if the asked permissions are in array(more than one)
        if(is_array($askedPermissions)){
            for($i=0; $i<count($askedPermissions);$i++){
                if(in_array($askedPermissions[$i], $role_permissions)== ""){
                    return false;
                }
            }
            return true;
        }else if(is_string($askedPermissions)){ //if the assked permission is only one(not array)
            if(in_array($askedPermissions, $role_permissions)){
                return true;
            }
        }

        return false;
    }

    /**
     * Get all the details of a user.
     *
     * @param    $userID and $askedDetails
     *           userId = "logged" will get the logged in user
     * @return array with all the asked details
     */ 
    function userDetails($userID, $askedDetails){
        if ($userID == "logged"){
            $userID = session()->get('user');
            
        }
        
        //get the name, id and suspended state
        if($askedDetails == "name&id"){
            $user = User::select('first_name','surname', 'suspended')->where('id', '=', $userID)->firstOrFail();
            $userBasicDetails = [
                'id'=> $userID,
                'name'=> $user['first_name'] . " " . $user['surname'],
            ];
            if ($user['suspended'] == "1"){
                $userBasicDetails['suspended'] = "suspended-user";
            }else{
                $userBasicDetails['suspended'] = "";
            }
            return $userBasicDetails;
        }
        if($askedDetails == "details"){
            $user = User::findOrFail($userID);
            return $user;
        }
        if($askedDetails == "role"){
            $user_role = User::select('role')->where('id', '=', $userID)->with('roles')->firstOrFail();
            return $user_role->roles;
        }
        
    }

    /**
     * Get all the details of a course.
     *
     * @param    $userID and $askedDetails
     *           userId = "logged" will get the logged in user
     * @return array with all the asked details
     */ 
    function courseDetails($courseID, $askedDetails){
        
        $details=[];
        if($askedDetails == "name&id"){
            $course = Course::select('name')->where('id', '=', $courseID)->firstOrFail();
            $courseBasicDetails = [
                'id'=> $courseID,
                'name'=> $course['name'],
            ];
            return $courseBasicDetails;
        }
        if($askedDetails == "details"){
            $course = Course::with('levels')->findOrFail($courseID);
            foreach($course->levels as $level){
                $level['lessons'] = lesson::where('level_id', '=', $level['id'])->orderBy('id','ASC')->get();
            }
            return $course;
        }
        
    }

    
    /**
     * Get the name of the Role by ID.
     *
     * @param    $ID
     * @return array with two elements (name and id)
     */ 
    function getRoleName($ID){
        $role = Role::select('name')->where('id', '=', $ID)->first();
        $role = $role->toArray();
        $roleName = [
            'id'=> $ID,
            'name'=> $role['name']
        ];
        return $roleName;
    }
    
    /**
     * Omit specifc count of chacacters from the beginning of a text.
     * get text proper direction
     *
     * @param    $string, $length
     * @return string 
     */ 
    function textFormatter(String $string, int $length = 0){
        //get text proper direction
        $pattern = "/[أاإآبتثجحخدذرزسشصضطظعغفقكلمنهويلاىؤئء]/";
        if(preg_match($pattern,$string)){
            $text['dir'] = "rtl";
        }else{
            $text['dir'] = "ltr";
        }
        //Omit specifc count of chacacters from the beginning of a text.
        if (strlen($string) > $length && $length > 0){
            $text['text'] = mb_substr($string,0,$length) . "...";
        }else{
            $text['text'] = $string;
        }
        return $text;
    }
