<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            
            'password'  => 'required',
          

        ]);

    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

      
        $credentials = $request->only('username','password');

    
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

      
        return response()->json([
            'success' => true,
            'message'    => 'login berhasil',    
            'token'   => $token   
        ], 200);

        
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token tidak valid'], 401);
        }

        return response()->json(compact('user'));
    }
}   