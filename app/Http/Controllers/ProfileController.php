<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $id = Auth::user()->pegawai_id;
        $data = DB::table('pegawai')
        ->select([
            'pegawai.*'
        ])
        ->whereNull('pegawai.deleted_at')
        ->where(['pegawai.pegawai_id' => $id])
        ->first();
        // dd($data);
        if(empty($data)){
            return Redirect::back()->with(['error' => 'Anda belum di daftarkan sebagai pegawai!']);
        }
        return view('profile.index', compact('data'));
    }

    public function update(Request $request){
        
        $nama_file = $request->foto;
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/foto_profile'), $file);
            $image = asset('dokumen/foto_profile/'.$nama_file);
            session(['foto_profile' => $image]);
        }
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_pegawai' => $request->nama_pegawai,
            'email' => $request->email,
            'telp' => $request->telp,
            'foto' => $nama_file,
        ];
        $pegawai_id = Crypt::decrypt($request->pegawai_id);
        DB::table('pegawai')->where(['pegawai_id' => $pegawai_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function gantiPassword(Request $request){
        $nama_file = $request->foto;
        $user = DB::table('users')->where(['id' => Auth::user()->id])->first();
        if(!empty($user->username)){
            if($user->password == $request->password_lama){
                $data = [
                    'updated_by' => Auth::user()->id,
                    'updated_at' => now(),
                    'password' => $request->password,
                ];
                DB::table('users')->where(['id' => Auth::user()->id])->update($data);
                return Redirect::back()->with(['success' => 'Password berhasil di ubah']);
            }elseif($request->password_baru !== $request->konfirmasi_password){
                return Redirect::back()->with(['error' => 'Password Konfrimasi berbeda']);
            }else{
                return Redirect::back()->with(['error' => 'Password lama tidak sama']);
            }
        }
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/foto_profile'), $file);
            $image = asset('dokumen/foto_profile/'.$nama_file);
            session(['foto_profile' => $image]);
        }
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_pegawai' => $request->nama_pegawai,
            'email' => $request->email,
            'telp' => $request->telp,
            'foto' => $nama_file,
        ];
        $pegawai_id = Crypt::decrypt($request->pegawai_id);
        DB::table('pegawai')->where(['pegawai_id' => $pegawai_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
}
