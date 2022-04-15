<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\SessionUser;
use App\Models\User;

class loginController extends Controller
{
    public function login(request $request) {
        $datalogin=[
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if (Auth::attempt($datalogin)) {
            $id = Auth::id();
            $checkTokenExit=SessionUser::where('user_id', $id)->first();
            if(empty($checkTokenExit)) {
                echo $id;
                $userSession=SessionUser::create([
                    'token' => Str::random(60),
                    'refresh_token' => Str::random(60) ,
                    'user_id' => $id,
                    'token_expreid' => date('Y-m-d H:i:s', strtotime('+30 day',time())),
                    
                ]);
                
            } else {
                $userSession=$checkTokenExit;
            }
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$userSession,
                    'status'=>200
                    
                ], 200
            );
        } else {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Password or username wrong !',
                    'status'=>401
                ], 200
            );
        }
    }
}