<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CpIndex;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\LevelsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LessonsController;
use App\Http\Controllers\Admin\UsersController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//AdminCP Routes
Route::group(['middleware' => ['protectedPages']], function () {

    //dashboard
    Route::get('/admincp', [CpIndex::class, 'getStatistics'])->name('dashboard');

    ###################################### Courses #######################################
    Route::group(['prefix' => 'admincp/courses'], function () {
        Route::get('/', [CoursesController::class, 'index'])->name('view.courses');
        Route::get('/create', [CoursesController::class, 'create'])->name('create.course');
        Route::post('/', [CoursesController::class, 'store'])->name('store.course');
        Route::get('/{course}', [CoursesController::class, 'show'])->name('show.course');
        Route::get('/{course}/edit', [CoursesController::class, 'edit'])->name('edit.course');
        Route::patch('/{course}', [CoursesController::class, 'update'])->name('update.course');
        Route::delete('/{course}', [CoursesController::class, 'destroy'])->name('delete.course');
    });
    ###################################### End Courses #######################################

    ###################################### Levels ###########################################
    Route::group(['prefix'=>'admincp/courses/{course}/levels'] , function () {
        Route::post('/', [LevelsController::class, 'store'])->name('store.level');
        Route::patch('/{level}', [LevelsController::class, 'update'])->name('update.level');
        Route::delete('/{level}', [LevelsController::class, 'destroy'])->name('delete.level');
    });
    ###################################### End Levels ####################################### 

    ###################################### Lessons ###########################################
    Route::group(['prefix'=>'admincp/courses/{course}/levels/{level}/lessons'] , function () {
        Route::get('/create', [LessonsController::class, 'create'])->name('create.lesson');
        Route::post('/', [LessonsController::class, 'store'])->name('store.lesson');
        Route::get('/{lesson}', [LessonsController::class, 'show'])->name('show.lesson');
        Route::get('/{lesson}/edit', [LessonsController::class, 'edit'])->name('edit.lesson');
        Route::patch('/{lesson}', [LessonsController::class, 'update'])->name('update.lesson');
        Route::delete('/{lesson}', [LessonsController::class, 'destroy'])->name('delete.lesson');
    }); 
    ###################################### End Lessons ####################################### 

    ###################################### Roles #############################################
    Route::prefix('admincp/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('view.roles');
        Route::get('/create', [RoleController::class, 'create'])->name('create.role');
        Route::post('/', [RoleController::class, 'store'])->name('store.role');
        Route::get('/authority', [RoleController::class, 'editRolesAuthority'])->name('edit.roles.authority');
        Route::post('/authority', [RoleController::class, 'updateRolesAuthority'])->name('update.roles.authority');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show.role');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit.role');
        Route::patch('/{role}', [RoleController::class, 'update'])->name('update.role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('delete.role');
        Route::post('/get-role-users', [RoleController::class, 'getRoleUsers'])->name('get.role.users');
    });

    ###################################### End Roles #############################################

    ################################### Users ###############################################
    Route::prefix('admincp/users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('view.users');
        Route::get('/create', [UsersController::class, 'create'])->name('create.user');
        Route::get('/suspended', [UsersController::class, 'viewSuspended'])->name('suspended.users');
        Route::post('/suspended/{user}', [UsersController::class, 'unsuspend'])->name('unsuspend.user');
        Route::post('/', [UsersController::class, 'store'])->name('store.user');
        Route::get('/{user}', [UsersController::class, 'show'])->name('show.user');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit.user');
        Route::patch('/{user}', [UsersController::class, 'update'])->name('update.user');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('suspend.user');
    });
    ################################# End Users #############################################
});
