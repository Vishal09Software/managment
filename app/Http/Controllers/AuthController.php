<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_check(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $remember = $request->has('remember_me');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard.');
        }

        return back()->with('error', 'Incorrect Login Details');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login');
    }


}
