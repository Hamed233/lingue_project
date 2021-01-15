<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Site\UserAuth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//login
Route::post('/session',[UserAuth::class, 'userLogin']);
Route::get('/session', function(){
    return redirect('login');
});

Route::get('login/', function () {
    App::setlocale('en'); 
    if(session()->has('user')){
        return redirect(route('main'));
    }else{
        return view('login');
    } 
})->name('login');

//logout page
Route::get('/logout', function () {
    if(session()->has('user')){
        session()->pull('user');
    }
    return redirect(route('login'));
});

//main page (landing pages for logged in users and for visitors)
Route::get('/', function(){
    if(session()->has('user')){
     return  view('home');
    }
    return view('welcome');
})->name('main');

//explore courses
Route::get('/courses', function(){
    return view('courses');
});

//logout page
Route::get('/test', function () {
    $users = userDetails('logged', "role")['authority'];
    return $users;//view('noAccess', compact('users'));
});