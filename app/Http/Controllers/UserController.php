<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   
    public function createUser(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:siswa,admin' 
        ]);

      
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

  
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => $request->role
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat.',
            'data' => $user
        ], 201);
    }

   
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

       
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|in:siswa,admin'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       
        if ($request->has('username')) {
            $user->username = $request->username;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password); 
        }
        if ($request->has('role') && $user->role !== 'admin') {
            $user->role = $request->role;
        }

        $user->save();

        return response()->json([
            'message' => 'User berhasil diperbarui.',
            'data' => $user
        ]);
    }

   
    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Data user ditemukan.',
            'data' => $user
        ]);
    }
    public function delete($id){
        $user=user::find($id);

    if (!$user){
        return response()->json(['status'=>false, 'message'=> "user dengan id $id tidak ditemukan"]);
    }
    $user->delete();
    return response()->json(['status'=>true,'message'=>'user berhasil dihapus']);
}
}