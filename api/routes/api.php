<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('login',[AuthController::class,'login']);
Route::post('register',[UserController::class,'store']);

Route::get('permissions',[\App\Http\Controllers\PermissionController::class,'index']);
Route::post('permissions',[\App\Http\Controllers\PermissionController::class,'store']);
Route::get('permissions/{permission}',[\App\Http\Controllers\PermissionController::class,'show']);
Route::put('permissions/{permission}',[\App\Http\Controllers\PermissionController::class,'update']);
Route::delete('permissions/{permission}',[\App\Http\Controllers\PermissionController::class,'destroy']);

Route::get('/getProfile',[\App\Http\Controllers\ProfileController::class,'index']);

Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::apiResource('roles',RoleController::class);
    Route::resource('users',UserController::class);
    Route::apiResource('profiles',\App\Http\Controllers\ProfileController::class);

});
