<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Util\JwtUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|'
        ]);

        $credentials = $request->only('email', 'password');

        $token = JwtUtil::generateAccessToken($credentials);
        if (!$token) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
                ]);
        }
        $user = auth()->user();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'SUCCESS',
            'authorization' => [
                'token' => $token,
                'user' => $user,
            ]
            ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = Auth::login($user);
        return response()->json([
            'status' => '200',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
            ],
        ]);
    }
}