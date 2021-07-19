<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function apiLogin(Request $request) {
        $user = User::where('email', $request->input('identifier'))
            ->orWhere('name', $request->input('identifier'))
            ->first();
        if(is_null($user)) return response([
            'message' => 'The credentials do not match our records'
        ], 401);
        if(Hash::check($request->input('password'), $user->password)) {
            $token = Crypt::encryptString($user->id);
            return response(['message' => 'Logged in successfully'], 200)->withCookie('Authentication', $token,  time() + (86400 * 30), '/');
        } else return response([
            'message' => 'The credentials do not match our records'
        ], 401);
    }

    public function logout() {
        Auth::logout();
        return response(['message' => 'User logged out successfully'], 200);
    }
}
