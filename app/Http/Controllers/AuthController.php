<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Kelas;
use App\Models\Notification;
use App\Models\Operasional;
use App\Models\Outbond;
use App\Models\Pegawai;
use App\Models\PemasukanLainnya;
use App\Models\Pembayaran;
use App\Models\PembayaranSiswa;
use App\Models\PembelianAset;
use App\Models\PembelianAtk;
use App\Models\PengeluaranLainnya;
use App\Models\Penggajian;
use App\Models\Pengurus;
use App\Models\PerbaikanAset;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{
    public function formLogin(){
        if(Auth::check()) return redirect()->back();
        return view('auth.login');
    }

    public function login(Request $req){
        // validation
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);
        $error = $validator->errors()->all();
        if ($validator->fails()) return redirect()->back()->withInput()->with('fail', $error);

        // check user
        $checkUser = User::where('name', $req->name)->first();
        if(!$checkUser) return redirect()->back()->withInput()->with('fail', 'User tidak ditemukan');

        // login user
        $credentials = $req->only('name', 'password');
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
        // Pemasukan
        // Pembayaran Siswa
        $psTotal1 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 1);
        })->sum('total');
        $psSisa1 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 1);
        })->sum('sisa');
        $psTotal2 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 2);
        })->sum('total');
        $psSisa2 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 2);
        })->sum('sisa');
        $psTotal3 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 3);
        })->sum('total');
        $psSisa3 = PembayaranSiswa::whereHas('siswa', function($q){
            $q->where('instansi_id', 3);
        })->sum('sisa');

        // Pemasukan Lainnya
        $pl1 = PemasukanLainnya::where('instansi_id', 1)->sum('total');
        $pl2 = PemasukanLainnya::where('instansi_id', 2)->sum('total');
        $pl3 = PemasukanLainnya::where('instansi_id', 3)->sum('total');

        
        // Pengeluaran
        // Beli Aset
        $pAset1 = PembelianAset::whereHas('supplier', function($q){
            $q->where('instansi_id', 1);
        })->sum('total');
        $pAset2 = PembelianAset::whereHas('supplier', function($q){
            $q->where('instansi_id', 2);
        })->sum('total');
        $pAset3 = PembelianAset::whereHas('supplier', function($q){
            $q->where('instansi_id', 3);
        })->sum('total');

        // Beli Atk
        $pAtk1 = PembelianAtk::whereHas('supplier', function($q){
            $q->where('instansi_id', 1);
        })->sum('total');
        $pAtk2 = PembelianAtk::whereHas('supplier', function($q){
            $q->where('instansi_id', 2);
        })->sum('total');
        $pAtk3 = PembelianAtk::whereHas('supplier', function($q){
            $q->where('instansi_id', 3);
        })->sum('total');

        // Gaji
        $pGaji1 = Penggajian::whereHas('pegawai', function($q){
            $q->where('instansi_id', 1);
        })->sum('total_gaji');
        $pGaji2 = Penggajian::whereHas('pegawai', function($q){
            $q->where('instansi_id', 2);
        })->sum('total_gaji');
        $pGaji3 = Penggajian::whereHas('pegawai', function($q){
            $q->where('instansi_id', 3);
        })->sum('total_gaji');

        // Perbaikan Aset
        $perAset1 = PerbaikanAset::where('instansi_id', 1)->sum('harga');
        $perAset2 = PerbaikanAset::where('instansi_id', 2)->sum('harga');
        $perAset3 = PerbaikanAset::where('instansi_id', 3)->sum('harga');

        // Operasional
        $pOp1 = Operasional::where('instansi_id', 1)->sum('jumlah_tagihan');
        $pOp2 = Operasional::where('instansi_id', 2)->sum('jumlah_tagihan');
        $pOp3 = Operasional::where('instansi_id', 3)->sum('jumlah_tagihan');

        // Outbond
        $pOut1 = Outbond::where('instansi_id', 1)->sum('harga_outbond');
        $pOut2 = Outbond::where('instansi_id', 2)->sum('harga_outbond');
        $pOut3 = Outbond::where('instansi_id', 3)->sum('harga_outbond');

        // Pengeluaran Lainnya
        $pLain1 = PengeluaranLainnya::where('instansi_id', 1)->sum('nominal');
        $pLain2 = PengeluaranLainnya::where('instansi_id', 2)->sum('nominal');
        $pLain3 = PengeluaranLainnya::where('instansi_id', 3)->sum('nominal');

        // Total Pemasukan
        $pemasukan1 = ($psTotal1 - $psSisa1) + $pl1;
        $pemasukan2 = ($psTotal2 - $psSisa2) + $pl2;
        $pemasukan3 = ($psTotal3 - $psSisa3) + $pl3;
        
        // Total Pengeluaran
        $pengeluaran1 = ($pAset1 + $pAtk1 + $pGaji1 + $perAset1 + $pOp1 + $pOut1 + $pLain1);
        $pengeluaran2 = ($pAset2 + $pAtk2 + $pGaji2 + $perAset2 + $pOp2 + $pOut2 + $pLain2);
        $pengeluaran3 = ($pAset3 + $pAtk3 + $pGaji3 + $perAset3 + $pOp3 + $pOut3 + $pLain3);
        
        // Saldo Kas
        $saldo1 = (($psTotal1 - $psSisa1) + $pl1) - ($pAset1 + $pAtk1 + $pGaji1 + $perAset1 + $pOp1 + $pOut1 + $pLain1);
        $saldo2 = (($psTotal2 - $psSisa2) + $pl2) - ($pAset2 + $pAtk2 + $pGaji2 + $perAset2 + $pOp2 + $pOut2 + $pLain1);
        $saldo3 = (($psTotal3 - $psSisa3) + $pl3) - ($pAset3 + $pAtk3 + $pGaji3 + $perAset3 + $pOp3 + $pOut3 + $pLain1);

        // Kelas
        $kelas2 = Kelas::where('instansi_id', 2)->count();
        $kelas3 = Kelas::where('instansi_id', 3)->count();

        // Siswa
        $siswa2 = Siswa::where('instansi_id', 2)->count();
        $siswa3 = Siswa::where('instansi_id', 3)->count();

        // Guru
        $guru2 = Pegawai::where('instansi_id', 2)->count();
        $guru3 = Pegawai::where('instansi_id', 3)->count();

        // Pengurus
        $pengurus1 = Pengurus::where('instansi_id', 1)->count();


        return view('dashboard', compact('pemasukan1', 'pemasukan2', 'pemasukan3', 'pengeluaran1', 'pengeluaran2', 'pengeluaran3', 'saldo1', 'saldo2', 'saldo3', 'kelas2', 'kelas3', 'siswa2', 'siswa3', 'guru2', 'guru3', 'pengurus1'));
    }

    public function pilih_instansi(){
        return view('pilih_instansi');
    }

    public function profile(Request $req, $instansi){
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = Auth::user();
        return view('profile', compact('data', 'data_instansi'));
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

        // check if update password
        if($req->old_password && $req->new_password){
            if (Hash::check($req->old_password, $user->password)) {
                $user->password = bcrypt($req->new_password);
            } else {
                return redirect()->back()->withInput()->with('fail', 'Password lama salah');
            }
        }

        if ($req->hasFile('photo')) {
            if ($req->hasFile('photo')) {
                $file = $req->file('photo');
                $fileContents = file_get_contents($file->getRealPath());
                $base64 = base64_encode($fileContents);
                $user->foto = $base64;
            }
        }

        $user->name = $req->name;
        $user->email = $req->email;
        $check = $user->update();
        if(!$check) return redirect(route('profile', ['instansi' => $req->instansi]))->with('fail', 'User gagal diupdate');
        return redirect(route('profile', ['instansi' => $req->instansi]))->with('success', 'User berhasil diupdate');
    }

    public function index_log($instansi){
        $data = Activity::orderByDesc('id')->get();
        return view('log.index', compact('data'));
    }

    public function show_log($instansi, $id){
        $data = Activity::find($id);
        return view('log.show', compact('data'));
    }

    public function notification($instansi)
    {
        $data_instansi = Instansi::where('nama_instansi', $instansi)->first();
        $data = Notification::where('instansi_id', $data_instansi->id)->where('isRead', false)->orderByDesc('id')->take(5)->get()->toArray();
        if(!$data) return response()->json('Not found', 404);
        return response()->json($data);
    }
}
