<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService extends BaseService
{
    /**
     * Get all users for the current tenant.
     */
    public function getAllUsers()
    {
        return User::orderBy('name')->get();
    }

    /**
     * Create a new user.
     */
    public function createUser(array $data)
    {
        return $this->transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);
            return User::create($data);
        });
    }

    /**
     * Update an existing user.
     */
    public function updateUser(int $id, array $data)
    {
        return $this->transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);
            
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            return $user;
        });
    }

    /**
     * Delete a user.
     */
    public function deleteUser(int $id)
    {
        return $this->transaction(function () use ($id) {
            $user = User::findOrFail($id);
            
            if ($user->id === session('user_id')) {
                throw new Exception("You cannot delete your own account.");
            }
            
            return $user->delete();
        });
    }
}
