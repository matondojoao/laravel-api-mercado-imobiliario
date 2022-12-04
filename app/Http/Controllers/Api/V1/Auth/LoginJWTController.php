<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Api\ApiMessages;

class LoginJWTController extends Controller
{
    public function login(Request $request)
    {
        $credentials=$request->all('email','password');

        if(! $token=Auth('api')->attempt($credentials)){
              $message=new ApiMessages('Unauthorized');
              return response()->json([$message->getMessage()], 401);
        }
        return response()->json([
            'token'=>$token,
        ], 200);
    }
}
