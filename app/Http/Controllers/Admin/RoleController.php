<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoleUsers(request $request)
    {
        //check permissions
        if(!hasAbility(['view_roles'])){
            abort(403);
        }
        $users= User::where('role', $request->role)->get();
        $users=json_encode($users);
        return $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check permissions
        if(!hasAbility(['view_roles'])){
            abort(403);
        }
        $roles   =  Role::orderBy('authority', 'ASC')
                    ->where('authority', '>', userDetails('logged','role')['authority'])
                    ->get();
        $index   =  1;
        return view("cp.roles.viewRoles", compact('roles','index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check permissions
        if(!hasAbility(['add_roles'])){
            abort(403);
        }
        //get only the permissions that the current loogedin user have
        //to prevent him from granting high permissions to other roles 
        $loggedUserPermissions = json_decode(userDetails('logged','role')['permissions']);
        //permissions to be shown to the user
        $permissions=[];
        foreach(Config('global.permissions') as $permission => $name){
            if(in_array($permission, $loggedUserPermissions)){
                $permissions[$permission] = $name;
            }
        }
        return view('cp.roles.createRole', compact('permissions'));
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
        if(!hasAbility(['add_roles'])){
            abort(403);
        }
        try{
            $rules = $this->getRules("storeAndUpdate");
            $messages= $this->getMessages("storeAndUpdate");
            $validator = validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
                return $validator->errors();
            }

            $role = $this->process(new Role, $request);
            if($role){
                return ['success' => 'The role was created successfully.'];
            }else{
                return ['error' => 'Something wrong happened on creating the role.'];
            }

        }catch (\Exception $ex){
            return $ex;
            //return a message or unhandled exception
            return ['error' => 'Something wrong happened on creating the role.'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //check permissions
        if(!hasAbility(['edit_roles'])){
            abort(403);
        }
        //get logged in user's role info
        $loggedUserRole = userDetails('logged','role');
        $loggedUserPermissions = json_decode($loggedUserRole['permissions']);
        $loggedUserAuthority = $loggedUserRole['authority'];
        //permissions to be shown to the user
        $permissions=[];
        //if the user is the superAdmin, all the permissions will be shown
        if($loggedUserAuthority == 1){
            $permissions=config('global.permissions');
        }else{
            //if the user is not the superAdmin, only the permissions he has will be shown
            //to prevent him from granting high permissions to other roles  
            foreach(Config('global.permissions') as $permission => $name){
                if(in_array($permission, $loggedUserPermissions)){
                    $permissions[$permission] = $name;
                }
            }
        }
        return view('cp.roles.editRole' , compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //check permissions
        if(!hasAbility(['edit_roles'])){
            abort(403);
        }
        try{
            $rules = $this->getRules("storeAndUpdate");
            $messages= $this->getMessages("storeAndUpdate");
            $validator = validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
                return $validator->errors();
            }

            $roleUpdate = $this->process(Role::findOrFail($role->id), $request);
            if($roleUpdate){
                return ['success' => 'The role was updated successfully.'];
            }else{
                return ['error' => 'Something wrong happened on updating the role.'];
            }

        }catch (\Exception $ex){
            return $ex;
            //return a message or unhandled exception
            return ['error' => 'Something wrong happened on updating the role.'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    /**
     * Define the roles authority.
     *
     * @return \Illuminate\Http\Response
     */
    public function editRolesAuthority()
    {
        //check permissions
        if(userDetails('logged','role')['authority'] != 1){
            abort(403);
        }
        $roles   =  Role::orderBy('authority', 'ASC')->get();
        return view("cp.roles.rolesAuthority", compact('roles'));
    }

    /**
     * Define the roles authority.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRolesAuthority(Request $request)
    {
         //check permissions
         if(userDetails('logged','role')['authority'] != 1){
            abort(403);
        }
        //decode the json array sent by the sortable element
        $roles_order=json_decode($request->authority_order);
        
        for($i=0; $i<count($roles_order);$i++){
            $role= Role::findOrFail($roles_order[$i]);
            $role->authority = $i+1;
            $role->save();
        }
        return ["Roles order was updated successfully."];
    }

    /**
     * Process inserting and updating the roles .
     *
     * @param    $methodName
     * @return   $role response
     */
    protected function process(Role $role, $request){
        $role->name = $request->name;
        $role->permissions = json_encode($request->permissions);
        $role->save();
        return $role;
    }


    /**
     * Get the forms validation rules by method name.
     *
     * @param    $methodName
     * @return   array of rules
     */
    protected function getRules($methodName){
        switch($methodName){
            case "storeAndUpdate":
                return $rules = [
                    'name'          => 'required',
                    'permissions'   => 'required|array|min:1',
                ];
            break;
        }
        
    }

    /**
     * Get the forms validation messages by method name.
     *
     * @param    $methodName
     * @return   a text mesages
     */
    protected function getMessages($methodName){
        switch($methodName){
            case "storeAndUpdate":
                return $messages = [
                    'name.required' => 'Please enter the name of the course.',
                    'permissions.required' => 'Please assign at least one permission.',
                    'permissions.min' => 'Please assign at least one permission.',
                    'permissions.array' => 'Please assign at least one permission.',
                ];
            break;
        }
        

    }

}
