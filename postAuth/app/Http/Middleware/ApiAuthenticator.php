<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;

class ApiAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle(Request $request, Closure $next)
    {
        if($request->hasCookie('Authentication')) {
            try{
                $cookie = $request->cookie('Authentication');//extracts cookie from the request
                $value = Crypt::decryptString($cookie);//decrypts the cookie to get the string value
                $user = User::find($value);//attempts to get a user from the value of the cookie
                if($value && $user){//if there is a user that matches that value
                    $request->attributes->add(['user' => $user]);//add the user found as an attribute to the request
                    Auth::onceUsingId($value);//this means the user is authenticated from when the request is received till a response is sent, and then the authentication is cancelled
                    return $next($request);//allow the request to proceed into the app
                }
                else
                    return response(["message" => "Unauthenticated"], 401);//authentication failled send unauthenticated message
            } catch(DecryptException $exp) {//catch decryption errors
                return response(["message" => "Unauthenticated"], 401);//authentication failled send unauthenticated message
            }
        }
        return response(["message" => "Unauthenticated"], 401);
    }

}
