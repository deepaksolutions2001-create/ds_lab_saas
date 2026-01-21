<?php

namespace App\Http\Controllers;

use App\Services\CustomAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(CustomAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin()
    {
        if (Session::has('user_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'interface' => 'required|in:admin,staff,client',
            'lab_code' => 'required_unless:interface,admin|nullable|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = $this->authService->authenticate(
            $request->input('interface'),
            $request->input('lab_code'),
            $request->input('email'),
            $request->input('password')
        );

        if ($user) {
            $welcomeMsg = "Welcome back, " . $user->name;
            if (Session::has('lab_name')) {
                $welcomeMsg .= " (" . Session::get('lab_name') . ")";
            }
            return redirect()->route('dashboard')->with('success', $welcomeMsg);
        }

        return back()->withErrors(['login_error' => 'Invalid credentials or inactive lab account.'])->withInput();
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
