<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
            //check permissions
            if(!hasAbility(['view_users'])){
                abort(403);
            }
            //get all users except the user himself and the suspended users
            $users   =  User::where('id' , '!=' , session()->get('user'))->where('suspended', '!=', 1)->with('roles')->get();

            $index   =  1; //for the ordering of table
            //filter: remove the superior users from the query
            $inferiorUsers=[];
            $loggedUserAuthority=userDetails('logged', "role")['authority'];
            foreach($users as $user){
                if($user->roles->authority >= $loggedUserAuthority){
                    //put the filtered users into a new array
                    $inferiorUsers[]=$user;
                }
            }
            return view("cp.users.viewUsers",)->with([
                "users"             => $inferiorUsers,
                "loggedUserAuthority"   => $loggedUserAuthority,
                "index"             => $index
                ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSuspended()
    {
            //check permissions
            if(!hasAbility(['view_users']) or !hasAbility(['suspend_users'])){
                abort(403);
            }
            //get all the suspended users
            $users   =  User::where('suspended', '=', 1)->with('roles')->get();

            $index   =  1; //for the ordering of table
            //filter: remove the superior users from the query
            $inferiorUsers=[];
            $loggedUserAuthority=userDetails('logged', "role")['authority'];
            foreach($users as $user){
                if($user->roles->authority >= $loggedUserAuthority){
                    //put the filtered users into a new array
                    $inferiorUsers[]=$user;
                }
            }

            return view("cp.users.viewSuspendedUsers",)->with([
                "users"             => $inferiorUsers,
                "loggedUserAuthority"   => $loggedUserAuthority,
                "index"             => $index
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check permissions
        if(!hasAbility(['add_users'])){
            abort(403);
        }
        ################ </Get the roles the user can assign to the others> #####################
        $roles = Role::orderBy('authority', 'DESC')->get();
        //filter: remove the superior roles from the query
        $loggedUserAuthority=userDetails('logged', "role")['authority'];
        foreach($roles as $role){
            if($role->authority > $loggedUserAuthority){
                //put the filtered users into a new array
                $inferiorRoles[]=$role;
            }
        }
        ################ </Get the the roles the user can assign to the others #####################
        return view('cp.users.createUser')->with(['roles'=> $inferiorRoles]);
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
        if(!hasAbility(['add_users'])){
            abort(403);
        }

        ############################### <validation of the form fields> ############################
        $rules = $this->getRules('storeAndUpdate');
        $messages = $this->getMessages('storeAndUpdate');
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return $validator->errors();
        }
        if(hasAbility('assign_roles')){
            //check if the user messed up with the roles select box
            $role = Role::where('id', '=', $request->role)->firstOrFail();
        }else{
            //if the user doesn't have the ability to assign roles, the new user will take the least role
            $role = Role::orderBy("authority", "DESC")->firstOrFail();
        }

        //check if the user messed up with the form to assign a superior role to a new user
        if($role['authority'] <= userDetails('logged', "role")['authority']){
            return ["error"=> "You can't assign a superior or equal role to yours to other users."];
        }
        //check if the email address exists
        if (User::where('email', '=', $request->email)->count() > 0){
            return ["error"=> "This email address exists before."];
        }
        ##############################</validation of the form fields>############################
        
        ############################## <inserting the user data> ################################
        $user= new User;
        $user->first_name   = $request->first_name;
        $user->surname      = $request->surname;
        $user->password     = Hash::make($request->password);
        $user->email        = $request->email;
        if(hasAbility('assign_roles')){
            $user->role     = $request->role;
        }else{
            $user->role     = $role['id'];
        }
        $user->save();
        return ["success" => "The user was created successfully."];
        ############################## </inserting the user data> ################################
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //check permissions
        if(!hasAbility(['add_users'])){
            abort(403);
        }
        if($user->roles->authority <= userDetails('logged', "role")['authority']){
            abort(403);
        }
        ################ </Get the roles the user can assign to the others> #####################
        $roles = Role::orderBy('authority', 'DESC')->get();
        //filter: remove the superior roles from the query
        $loggedUserAuthority=userDetails('logged', "role")['authority'];
        foreach($roles as $role){
            if($role['authority'] > $loggedUserAuthority){
                //put the filtered users into a new array
                $inferiorRoles[]=$role;
            }
        }
        ################ </Get the the roles the user can assign to the others #####################
        return view('cp.users.editUser')->with(['roles'=> $inferiorRoles, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
         //check permissions
        if(!hasAbility(['edit_users'])){
            abort(403);
        }
        if($user->roles->authority <= userDetails('logged', "role")['authority']){
            abort(403);
        }
        ############################### <validation of the form fields> ############################
        if(!$request->password and !$request->password_confirmation){
            $rules = $this->getRules('storeAndUpdate', 'no-password');
        }else{
            $rules = $this->getRules('storeAndUpdate');
        }
        $messages = $this->getMessages('storeAndUpdate');
        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return $validator->errors();
        }
        if(hasAbility('assign_roles')){
            //check if the user messed up with the roles select box
            $role = Role::where('id', '=', $request->role)->firstOrFail();
        }else{
            //if the user doesn't have the ability to assign roles, the new user will take the least role
            $role = Role::orderBy("authority", "DESC")->firstOrFail();
        }

        //check if the user messed up with the form to assign a superior role to a new user
        if($role->authority <= userDetails('logged', "role")['authority']){
            return ["error"=> "You can't assign a superior or equal role to yours to other users."];
        }
        //check if the email address exists and except the email of the user
        if (User::where('email', '=', $request->email)->where('id' , '!=', $user->id)->count() > 0){
            return ["error"=> "This email address exists before."];
        }
        ##############################</validation of the form fields>############################
        
        ############################## <inserting the user data> ################################
        $user->first_name   = $request->first_name;
        $user->surname      = $request->surname;
        //check if the password was changed
        if($request->password and $request->password_confirmation){
            $user->password     = Hash::make($request->password);
        }

        $user->email        = $request->email;
        if(hasAbility('assign_roles')){
            $user->role     = $request->role;
        }else{
            $user->role     = $role['id'];
        }
        $user->save();
        return ["success" => "The user was updated successfully."];
        ############################## </inserting the user data> ################################
    }

    /**
     * Suspend the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
          //check permissions
        if(!hasAbility(['suspend_users'])){
            abort(403);
        }
        if($user->roles->authority <= userDetails('logged', "role")['authority']){
            abort(403);
        }
        $user->suspended = 1;
        $user->save();
        return ["success"=> "The user was suspended successfully."];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function unsuspend(user $user)
    {
        
          //check permissions
        if(!hasAbility(['suspend_users'])){
            abort(403);
        }
        if($user->roles->authority <= userDetails('logged', "role")['authority']){
            abort(403);
        }
        $user->suspended = 0;
        $user->save();
        return ["success"=> "The user was unsuspended successfully."];
    }

        /**
     * Get the forms validation rules by method name.
     *
     * @param    $methodName
     * @return \Illuminate\Http\Response
     */
    protected function getRules($methodName, $noPassword="")
    {
        switch($methodName){
            case "storeAndUpdate":
                $rules = [
                        'first_name'  => 'required|min:3|max:15',
                        'surname'     => 'required|min:3|max:15',
                        'email'       => 'required|email|max:255',
                        
                ];
                //remove password verification if it wasn't changed on update
                if($noPassword != "no-password"){
                    $rules['password'] = 'required|confirmed|min:8';
                }
                if(hasAbility('assign_roles')){
                    $rules['role'] = 'required|max:11|min:1';
                }
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
    protected function getMessages($methodName)
    {
        switch($methodName){
            case "storeAndUpdate":
                return $messages = [
                    'first_name.required'   => 'Please enter the first name.',
                    'first_name.min'        => 'The first name should be at least 3 characters.',
                    'first_name.max'        => 'The first name should be maximum 15 characters.',
                    'surname.required'      => 'Please enter the surname.',
                    'surname.min'           => 'The surname should be at least 3 characters.',
                    'surname.max'           => 'The surname should be maximum 15 characters.',
                    'email.required'        => "Please enter the email address.",
                    'email.email'           => "This isn't a valid email address.",
                    'email.max'             => "The given email address is too long.",
                    'role.required'         => "Please select a role.",
                    'role.min'              => "There is somthing wrong with the selected role.",
                    'role.max'              => "The selected role is not valid.",
                    'password.required'     => 'The surname should be at least 3 characters.',
                    'password.min'          => "The password should be at least 8 characters.",
                    'password.confirmed'    => "The given passwords don't match.",
                ];
            break;
        }
        

    }
}
