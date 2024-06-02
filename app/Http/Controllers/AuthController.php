<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function formLogin(){
        // if(Auth::check()) return redirect()->back();
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
            return redirect()->intended('/pilih-instansi')->with('success', 'User berhasil login');
        }
        return redirect()->back()->withInput()->with('fail', 'User gagal login');
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

    public function dashboard($instansi){
        // pembayaran
        // $pembayaranSekolah = Pembayaran::with('tagihan.daftar_tagihan')->get();
        // $sekolahIn = 0;
        // $yayasanIn = 0;
        // foreach ($pembayaranSekolah as $data) {
        //     $sekolahIn += $data->nominal * ($data->tagihan->daftar_tagihan->persen_yayasan / 100);
        //     $yayasanIn += $data->nominal * ((100 - $data->tagihan->daftar_tagihan->persen_yayasan) / 100);
        // }
        return view('dashboard');
    }

    public function pilih_instansi(){
        return view('pilih_instansi');
    }

    public function profile(Request $req){
        $instansi = $req->instansi;
        $data = Auth::user();
        return view('profile', compact('data', 'instansi'));
    }

    public function profile_update(Request $req){
        // validation
        $validator = Validator::make($req->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect(route('profile', ['instansi' => $req->instansi]))->withInput()->with('fail', $error);
        
        // update data
        $user = User::find($req->id);
        $user->name = $req->name;
        $user->email = $req->email;
        $check = $user->update();
        if(!$check) return redirect(route('profile', ['instansi' => $req->instansi]))->with('fail', 'User gagal diupdate');
        return redirect(route('profile', ['instansi' => $req->instansi]))->with('success', 'User berhasil diupdate');
    }
}
