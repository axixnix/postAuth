<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Utils\RandomFunctions; // was needed in order to use RandomFunctions::generateRandomString(15);
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function registerUser(Request $request){
        $request->validate([//calling the validate method on the request to validate its contents
          'name'=>'required|string',//name is required and the data type must be string
          'email'=>'required|string|email|unique:users',
          'password'=>'required|string'//password is required and the data type must be string

        ]);

        //$check = true;

       /* do{
            $string = RandomFunctions::generateRandomString(15);
            $user = User::where('url',$string)->first();
            if(is_null($user)) $check = false;
        }
        while($check);*/ //needed this to generate the random url for the anonymous messages

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            //'url' => $string //no longer needed as this is no longer the anonymous messages app
        ]);

        return response(['user created successfully'],200);

    }
}
