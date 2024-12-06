<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'username' => 'required|string',
        
    //         'password' => 'required|string|min:6',
    //     ]);

    //     $user = User::create([
    //         'username' => $request->name,
      
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return response()->json(['message' => 'User  registered successfully'], 201);
    // }
    public function register(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'username'      => 'required',
            'email' => 'required|String|email|unique:users',
            'password'  => 'required|min:8',
            'role' => 'required|in:siswa,admin'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

     
        $user = User::create([
            'name'      => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password'  => Hash::make($request->password), // Hash password
            'role' => $request->role
        ]);

        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }}
    
        

    // Fungsi untuk mendapatkan user yang sedang login
    // public function getAuthenticatedUser()
    // {
    //     try {
    //         if (!$user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['user_not_found'], 404);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Token tidak valid'], 401);
    //     }

    //     return response()->json(compact('user'));
    // }
  }



