<?php

namespace App\Util;

use Illuminate\Support\Facades\Auth;

class JwtUtil {

    public static function getToken($request) {
        //Get token from Header
        $token = $request->bearerToken();

        return $token;
    }

    public static function generateAccessToken($credentials) {
        $token = Auth::attempt($credentials);

        if (!$token) {
            return false;
        }

        return $token;
    }

    public static function parseAccessToken($token) {
    
            //Authenticate te token
            $payload = auth()->payload();

            //Return the claims
            return $payload;
        
    }
}