<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user and return the record
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $credentials)
    {
        if (!auth()->attempt($credentials)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $token = auth()->user()->createToken('InstaJam-app')->plainTextToken;

        return response(['token' => $token], 200);
    }
}
