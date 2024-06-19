<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        
    }

    public function create(array $data): User
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->assignRole($data['role']);
            
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
       
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

}
