<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function login(AuthRequest $request){

        // dd('stop');
        $request->validated();
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        return response()->json([
           'message'=> 'Unauthorized'
        ],401);

        $user = $request->user();
        $tokenResult = $user->createToken('token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();
        // dd([

        //    "access_token" => $tokenResult->accessToken,
        //    "token_type" => "Bearer",
        //    "expires_at" => Carbon::parse(
        //        $tokenResult->token->expires_at
        //     )->toDateTimeString()
        // ]);

    return response()->json([

        "access_token" => $tokenResult->accessToken,
        "token_type" => "Bearer",
        "expires_at" => Carbon::parse(
            $tokenResult->token->expires_at
         )->toDateTimeString()
     ]);
    }
}
