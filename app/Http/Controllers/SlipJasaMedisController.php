<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SlipJasaMedisController extends Controller
{
    public function index()
    {
        $pegawai_id = Auth::user()->pegawai_id;
        // $pegawai = DB::table('pegawai')->where('pegawai_id', $pegawai_id)->first();
        $data = DB::table('jasa_medis')->leftJoin('pegawai', 'jasa_medis.pegawai_id','pegawai.pegawai_id')->leftJoin('bagian', 'pegawai.bagian_id','bagian.bagian_id')->whereNull('jasa_medis.deleted_at')->where('jasa_medis.pegawai_id',$pegawai_id)->get();
        // dd($data);
        return view('penggajian.slip_jasa_medis.index', compact('data'));
    }
    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
        return view('penggajian.penggajian_manual.detail', compact('data'));
    }
    
}
