<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\IUserRepository;
use App\Util\JwtUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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

        $user = $this->userRepository->createUser($request);
        if (!$user) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User created falied',
            ], 401);
        }
        $token = Auth::login($user);
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
            ],
        ]);
    }
}