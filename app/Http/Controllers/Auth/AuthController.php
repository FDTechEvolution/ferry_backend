<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

use App\Models\User;
use App\Models\UserLog;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    public function username()
    {
        return 'username';
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where(['username' => $credentials['username']])->with('role')->first();
        if($user) {
            $result = $this->checkUserCondition($user);
            if(!$result) return back()->withFail('Your provided credentials do not match in our records.');
            else {
                // return redirect()->route('dashboard');
                if(Auth::attempt($credentials))
                {
                    UserLog::create([
                        'user_id' => Auth::user()->id,
                        'activity' => 'login',
                        'datetime' => date('Y-m-d H:i:s')
                    ]);

                    $request->session()->regenerate();
                    return redirect()->route('dashboard')
                        ->withSuccess('Welcome '.Auth::user()->username);
                }
            }
        }
        
        return back()->withFail('Your provided credentials do not match in our records.');
    }

    private function checkUserCondition($user) {
        if($user->role->name == 'Admin' || $user->role->name == 'Agent') {
            if($user->isactive && $user->status == 'CO') return true;
        }
        return false;
    }

    public function sendLinkToEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
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
