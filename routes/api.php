<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\ProjectInfoController;
use App\Http\Controllers\StackInfoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/personal-info', [PersonalInfoController::class, 'showStock']);
Route::get('/project-info', [ProjectInfoController::class, 'showStock']);
Route::get('/stack-info', [StackInfoController::class, 'showStock']);


Route::middleware(['auth:sanctum'])->group(function () {

Route::post('/logout', [UserController::class, 'logout']);

Route::get('/personal-info/user', [PersonalInfoController::class, 'show']);
Route::post('/personal-info/user/images/add', [PersonalInfoController::class, 'addImages']);   ;
Route::delete('/personal-info/user/{id}/images/remove/{image_id}', [PersonalInfoController::class, 'removeImage']);
Route::Post('/personal-info/user', [PersonalInfoController::class, 'store']);


Route::get('/project-info/user', [ProjectInfoController::class, 'show']);
Route::post('/project-info/user/{id}/images/add', [ProjectInfoController::class, 'addImages']);
Route::delete('/project-info/user/{id}/images/remove/{image_id}', [ProjectInfoController::class, 'removeImage']);
Route::Post('/project-info/user/add', [ProjectInfoController::class, 'store']);
Route::Post('/project-info/user/update/{id}', [ProjectInfoController::class, 'update']);
Route::delete('/project-info/user/{id}', [ProjectInfoController::class, 'delete']);


Route::get('/stack-info/user', [StackInfoController::class, 'show']);
Route::post('/stack-info/user/{id}/images/add', [StackInfoController::class, 'addImages']);
Route::delete('/stack-info/user/{id}/images/remove/{image_id}', [StackInfoController::class, 'removeImage']);
Route::Post('/stack-info/user', [StackInfoController::class, 'store']);
Route::Post('/stack-info/user/update/{id}', [StackInfoController::class, 'update']);
Route::delete('/stack-info/user/{id}', [StackInfoController::class, 'delete']);


});
