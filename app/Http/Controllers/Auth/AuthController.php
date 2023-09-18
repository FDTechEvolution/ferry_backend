<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    public function login() {
        return view('index');
    }

    public function forgotPassword() {
        return view('pages.auth.forgot_password');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where(['email' => $credentials['email']])->with('role')->first();
        if($user->role->name !== 'Admin') return back()->withErrors(['email' => 'Your provided credentials do not match in our records.',]);
        else {
            // return redirect()->route('dashboard');
            if(Auth::attempt($credentials))
            {
                $request->session()->regenerate();
                return redirect()->route('dashboard')
                    ->withSuccess('You have successfully logged in!');
            }

            return back()->withErrors([
                'email' => 'Your provided credentials do not match in our records.',
            ])->onlyInput('email');
        }
    }

    public function resetPassword(Request $request) {
        return redirect()->route('login');
    }

    public function dashboard() {
        if(Auth::check()) {
            return view('dashboard');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }
    }
}
