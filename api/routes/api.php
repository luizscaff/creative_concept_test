<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\UserController;

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
Route::post('login', [AuthController::Class, 'login']);

Route::group(['middleware' => 'jwt'], function($router) {
  Route::post('logout',           [AuthController::Class,       'logout']);

  Route::get('tasks',             [TaskController::Class,       'All']);
  Route::get('tasks/{idTask}',    [TaskController::Class,       'Get']);
  Route::post('tasks',            [TaskController::Class,       'Store']);
  Route::put('tasks/{idTask}',    [TaskController::Class,       'Update']);
  Route::delete('tasks/{idTask}', [TaskController::Class,       'Delete']);

  Route::get('task_statuses',     [TaskStatusController::Class, 'All']);

  Route::get('users',             [UserController::Class,       'All']);
  Route::get('users/{id}',        [UserController::Class,       'Get']);
  Route::post('users',            [UserController::Class,       'Store']);
  Route::put('users/{id}',        [UserController::Class,       'Update']);
  Route::delete('users/{id}',     [UserController::Class,       'Delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
