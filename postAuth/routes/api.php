<?php

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[RegisterController::class,'registerUser']);

Route::post('/login',[LoginController::class,'apiLogin']);

Route::post('/logout',[LoginController::class,'logout']);


Route::middleware('apiAuthenticator')->group(function () {
    Route::get("dashboard", function() {
        return view('loggedin');
    });
});

//postauth is the remote name
