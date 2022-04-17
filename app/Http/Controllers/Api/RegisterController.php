<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class RegisterController extends Controller
{
    public function register(Request $request) {
        $userCreate = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(
            [
                'errorCode'=>0,
                'data'=>$userCreate,
                'status'=>200
            ], 200
        );
    }
}