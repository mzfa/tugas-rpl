<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function ganti_proyek(Request $request){
        $proyek = DB::table('proyek')->whereNull('deleted_at')->where('proyek_id',$request->proyek)->first();
        if(empty($proyek)){
            return Redirect::back()->with(['error' => 'Anda gagal mengganti proyek!']);
        }
        session(['proyek_aktif' => [
            'id' => $proyek->proyek_id,
            'nama_proyek' => $proyek->nama_proyek
        ]]);
        return Redirect::back()->with(['success' => 'Anda berhasil mengganti proyek!']);
    }
    public function buat_password(Request $request){
        $pegawai_id = Auth::user()->pegawai_id;
        $request->validate([
            'password_detail' => ['required', 'string'],
        ]);
        // dd($pegawai_id);
        $data = [
            'password_detail' => $request->password_detail,
        ];
        DB::table('pegawai')->where(['pegawai_id' => $pegawai_id])->update($data);
        session(['password_detail' => $request->password_detail]);
        return Redirect::back()->with(['success' => 'Password Berhasil di buat!']);
    }

    public function doc_command(Request $request){
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'dokumen_id' => $request->id,
            'isi_command' => $request->command,
        ];
        DB::table('command')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
}
