<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $users = User::with('role')->get();
        $roles = Role::get();
        return view('pages.users.index', ['users' => $users, 'roles' => $roles]);
    }

    public function store(Request $request) {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|string'
        ]);

        if(!$this->checkEmail($request->email)) return redirect()->route('users-index')->withError('อีเมล์นี้มีผู้ใช้งานแล้ว กรุณาตรวจสอบ...');

        $user = User::create([
            'code' => Str::random(6),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role_id' => $request->role,
            'isactive' => true
        ]);

        if($user) return redirect()->route('users-index')->withSuccess('เพิ่มผู้ใช้งานเรียบร้อยแล้ว...');
        else return redirect()->route('users-index')->withError('เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }

    private function checkEmail($email, $user_id = null) {
        $user = User::where('email', $email)->where('id', '!=', $user_id)->first();
        if($user) return false;
        return true;
    }

    public function update(Request $request) {
        if(!$this->checkEmail($request->email, $request->user_edit)) return redirect()->route('users-index')->withError('อีเมล์นี้มีผู้ใช้งานแล้ว กรุณาตรวจสอบ...');

        $user = User::find($request->user_edit);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->isactive = isset($request->isactive) ? 1 : 0;

        if($user->save()) return redirect()->route('users-index')->withSuccess('แก้ไขรายละเอียดผู้ใช้งานเรียบร้อยแล้ว...');
        else return redirect()->route('users-index')->withError('เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }
}
