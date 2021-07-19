<?php

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Auth\RegisterController;

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


Route::middleware('apiAuthenticator')->group('/login',function () {
return view('loggedin');//using my authenticator to protect the loggedin view
});

