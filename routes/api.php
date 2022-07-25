<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserCtrl;
use App\Http\Controllers\Api\TeamCtrl;
use App\Http\Controllers\Api\UitCtrl;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// user
Route::post('/signup', [UserCtrl::class, 'CreateNewUser']);
Route::post('/login', [UserCtrl::class, 'Login']);
Route::get('/get_user/{id}', [UserCtrl::class, 'GetUser']);
Route::get('/get_users', [UserCtrl::class, 'GetUsers']);

// team
Route::post('/team/add', [TeamCtrl::class, 'CreateNewTeam']);
Route::get('/team/getteam', [TeamCtrl::class, 'GetTeams']);
