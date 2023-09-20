<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Models\User; 

class ForgotPasswordController extends Controller
{
    public function submitForgetPasswordForm(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if($user) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'id' => Str::uuid(),
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
    
            Mail::send('email.reset-password', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });
        }

        return back()->withSuccess('ส่งลิงค์การรีเซ็ตรหัสผ่านไปยังอีเมล์เรียบร้อยแล้ว อาจใช้เวลาซักครู่...');
    }

    public function submitResetPasswordForm(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
 
        $updatePassword = DB::table('password_resets')
                            ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword) return back()->withFail('การยืนยันตัวตนไม่ถูกต้อง....');
    
        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect()->route('login')->withSuccess('รีเซ็ตรหัสผ่านใหม่เรียบร้อยแล้ว...');
    }
}
