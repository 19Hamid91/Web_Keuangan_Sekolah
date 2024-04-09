<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function formLogin(){
        return view('auth.login');
    }

    public function login(Request $req){
        // validation
        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // check user
        $checkUser = User::where('email', $req->email)->first();
        if(!$checkUser) return redirect()->back()->withInput()->with('fail', 'User tidak ditemukan');

        // login user
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', 'User berhasil login');
        }
        return redirect()->back()->withInput()->with('fail', 'user gagal login');
    }

    public function formRegister(){
        return view('auth.register');
    }

    public function register(Request $req){
        // validation
        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'nip' => 'required',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // check user
        $checkUser = User::where('email', $req->email)->first();
        $checkNip = User::where('nip', $req->nip)->first();
        if($checkUser) return redirect()->back()->withInput()->with('fail', 'Username telah dipakai');
        if($checkNip) return redirect()->back()->withInput()->with('fail', 'NIP telah dipakai');

        // create user
        $data = $req->except(['_token', '_method']);
        $data['role'] = 'USER';
        $data['password'] = bcrypt($data['password']);
        $check = User::create($data);
        if(!$check) return redirect()->back()->withInput()->with('fail', 'Gagal membuat user baru');

        // redirect login
        return redirect('login')->with('success', 'User telah dibuat, silakan login');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }

    public function dashboard(){
        return view('dashboard');
    }
}
