<?php 

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository {

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;        
    }

    public function createUser(Request $request) {
        try {
            $user = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $user;
        } catch (Exception $exc) {
            return false;
        }
    }
 }