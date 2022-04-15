<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SessionUser;
class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->header('token');
        $checkToken=SessionUser::where('token',$token)->first();
        if(empty($token)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Token is null',
                    'status'=>401
                ], 200
            );
        } elseif(!empty($checkToken)) {
            return $next($request);
        } else {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Token does not exist',
                    'status'=>401
                    
                ], 200
            );
        }
    }
}