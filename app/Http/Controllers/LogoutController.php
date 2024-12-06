<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExperiedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
    $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
    if($removeToken) {
        return response()->json([
            'succes' => true,
            'message' => 'logout berhasil',
        ]);
    }

    }
}
