<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserCtrl;
use App\Http\Controllers\Api\TeamCtrl;
use App\Http\Controllers\Api\ProjectCtrl;
use App\Http\Controllers\Api\ActivityCtrl;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/



// user
Route::post('project/v1/signup', [UserCtrl::class, 'CreateNewUser']);
Route::post('project/v1/login', [UserCtrl::class, 'Login']);
Route::get('project/v1/get_user/{id}', [UserCtrl::class, 'GetUser']);
Route::get('project/v1/get_users', [UserCtrl::class, 'GetUsers']);

// team
Route::post('project/v1/team/add', [TeamCtrl::class, 'CreateNewTeam']);
Route::get('project/v1/team/get', [TeamCtrl::class, 'GetTeams']);
Route::get('project/v1/team/get/{id}', [TeamCtrl::class, 'GetTeam']);
Route::put('project/v1/team/update', [TeamCtrl::class, 'UpdateTeam']);
Route::delete('project/v1/team/delete/{id}', [TeamCtrl::class, 'DeleteTeam']);

Route::get('project/v1/team/getuits', [TeamCtrl::class, 'GetUits']);

// project
Route::post('project/v1/project/add', [ProjectCtrl::class, 'CreateNewProject']);
Route::get('project/v1/project/get', [ProjectCtrl::class, 'GetProjects']);
Route::get('project/v1/project/get/{id}', [ProjectCtrl::class, 'GetProject']);
Route::put('project/v1/project/update', [ProjectCtrl::class, 'UpdateProject']);

// activity
Route::get('/project/v1/activity/get', [ActivityCtrl::class, 'GetActivities']);
