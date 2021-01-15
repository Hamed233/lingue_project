<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuth extends Controller
{
 
    function userLogin(Request $rec){
        
        // <validation of login fields>
        $rules = $this->getRules();
        $messages = $this->getMessages();
        $validator = Validator::make($rec->all(),$rules,$messages);
        
        if($validator->fails()){
            return $validator->errors();
        }
         // </validation of login fields>
        
         //<checking_user_credentials_by_function_checkCredentials>
        $userData = $this->checkCredentials($rec->input('email'), $rec->input('password'));
        if(!$userData){
            return json_encode(["message"=>"The email address that you've entered doesn't match any account."]);
        }elseif($userData == "wrong_password"){
            return json_encode(["message"=>"The password that you've entered is incorrect."]);
        }elseif($userData == "suspended"){
            return json_encode(["message"=>"Your account is suspended."]);
        }else{
            $rec->session()->put('user',$userData->id);
            return json_encode(["message"=>"You logged in successfully."]);
        }
        //</checking_user_credentials_by_function_checkCredentials>
    }

     // validation rules
    protected function getRules(){
            return $rules = [
                'email' => 'required',
                'password' => 'required',
            ];
    }

    // validation messages
    protected function getMessages(){
        return $messages = [
            'email.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.',
        ];
    
    }

    // check user credentials
    public function checkCredentials($email, $password){
        $userData =  user::where('email', '=', $email)->first();
        if (!$userData) return null;
        if (Hash::check($password, $userData->password)){
            if($userData->suspended){
                return "suspended";
            }
            return $userData;
        }else{
            return "wrong_password";
        }
       
    }
}
