<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;
use Mail; 

use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $users = User::with('role')->where('status', 'CO')->get();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('pages.users.index', ['users' => $users, 'roles' => $roles]);
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'office' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable'
        ]);

        if(!$this->checkUsername($request->username)) return redirect()->route('users-index')->withFail('This username is exist...');
        if(!$this->checkEmail($request->email)) return redirect()->route('users-index')->withFail('This email address is exist...');

        $slug_image = null;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $slug_image = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/assets/images/avatar'), $slug_image);
        }

        $user = User::create([
            'code' => Str::random(6),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'isactive' => true,
            'status' => 'CO',
            'office' => $request->office,
            'image' => $slug_image
        ]);

        if($user) return redirect()->route('users-index')->withSuccess('Account created...');
        else return redirect()->route('users-index')->withFail('Something is wrong. Please try again.');
    }

    private function checkEmail(string $email, string $user_id = null) {
        $user = User::where('email', $email)->where('id', '!=', $user_id)->first();
        if($user) return false;
        return true;
    }

    private function checkUsername(string $username, string $user_id = null) {
        $user = User::where('username', $username)->where('id', '!=', $user_id)->first();
        if($user) return false;
        return true;
    }

    public function update(Request $request) {
        $request->validate([
            'firstname' => 'required|string',
            'username'=> 'required|string',
            'lastname' => 'required|string',
            'office' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable'
        ]);

        if(!$this->checkUsername($request->username, $request->id)) return redirect()->route('users-index')->withFail('This username is exist...');
        if(!$this->checkEmail($request->email, $request->id)) return redirect()->route('users-index')->withFail('This email address is exist...');

        $user = User::find($request->id);

        $slug_image = null;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $slug_image = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/assets/images/avatar'), $slug_image);
        }

        if($user->image != '') unlink(public_path().'/assets/images/avatar/'. $user->image);

        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->office = $request->office;
        if($slug_image != null) $user->image = $slug_image;
        $user->isactive = isset($request->isactive) ? 1 : 0;

        if($user->save()) return redirect()->route('users-index')->withSuccess('Account updated...');
        else return redirect()->route('users-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $user = User::find($id);
        $user->status = 'VO';

        if($user->save()) return redirect()->route('users-index')->withSuccess('Account deleted...');
        return redirect()->route('users-index')->withFail('Something is wrong. Please try again.');
    }

    public function resetUserPassword(string $id = null) {
        $user = User::find($id);
        if($user) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'id' => Str::uuid(),
                'email' => $user->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
    
            Mail::send('email.reset-password', ['token' => $token], function($message) use($user){
                $message->to($user->email);
                $message->subject('Reset Password');
            });
        }

        return back()->withSuccess('A link to reset your password will be sent to your email : '.$user->email);
    }
}
