<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user and return the record
     */
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Check credentials and return the matching user if exists
     */
    public function login(array $credentials): bool|Authenticatable|null
    {
        if (! auth()->attempt($credentials)) {
            return false;
        }

        return auth()->user();
    }
}
