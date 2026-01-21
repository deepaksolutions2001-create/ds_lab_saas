<?php

namespace App\Services;

use App\Models\User;
use App\Models\Lab;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthService
{
    /**
     * Authenticate a user and initialize the session.
     * 
     * @param string $loginType 'admin', 'staff', or 'client'
     * @param string|null $labCode Required for staff and client
     * @param string $username User email or custom username
     * @param string $password
     * @return User|false
     */
    public function authenticate(string $loginType, ?string $labCode, string $username, string $password)
    {
        $query = User::where('email', $username); // or username if we add it

        // 1. Super Admin doesn't need lab code
        if ($loginType === 'admin') {
            $user = $query->where('role', 'super_admin')->first();
            if ($user && Hash::check($password, $user->password)) {
                $this->initializeSession($user);
                return $user;
            }
            return false;
        }

        // 2. Staff and Clients MUST have a valid Lab Code
        if (!$labCode) return false;

        $lab = Lab::where('code', $labCode)->where('is_active', true)->first();
        if (!$lab) return false;

        $user = $query->where('lab_id', $lab->id)
                      ->whereIn('role', ['lab_admin', 'staff', 'client'])
                      ->first();

        if ($user && Hash::check($password, $user->password)) {
            $this->initializeSession($user, $lab);
            return $user;
        }

        return false;
    }

    /**
     * Set up the session with user and lab details.
     */
    protected function initializeSession(User $user, ?Lab $lab = null)
    {
        Session::flush(); // Security: Clear old sessions

        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $user->role);

        if ($user->role !== 'super_admin' && $lab) {
            Session::put('lab_id', $lab->id);
            Session::put('lab_name', $lab->name);
            Session::put('lab_code', $lab->code);

            // Fetch current active financial year for this lab
            $fy = FinancialYear::where('lab_id', $lab->id)
                ->where('is_active', true)
                ->where('is_closed', false)
                ->first();

            if ($fy) {
                Session::put('financial_year_id', $fy->id);
                Session::put('financial_year_name', $fy->name);
            }

            // If client, stash client_id
            if ($user->role === 'client') {
                Session::put('client_id', $user->client_id);
            }
        }
    }

    /**
     * Logout and destroy session.
     */
    public function logout()
    {
        Session::flush();
    }
}
