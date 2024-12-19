<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\PDF as PDF;

class SlipGajiController extends Controller
{
    public function index()
    {
        $pegawai_id = Auth::user()->pegawai_id;
        $pegawai = DB::table('pegawai')
        ->leftJoin('pegawai_detail', 'pegawai.pegawai_id', '=', 'pegawai_detail.pegawai_id')
        ->leftJoin('struktur', 'pegawai.struktur_id', '=', 'struktur.struktur_id')
        ->select([
            'pegawai.*',
            'struktur.nama_struktur',
        ])
        ->whereNull('pegawai.deleted_at')
        ->where('pegawai.pegawai_id', $pegawai_id)
        ->first();
        if(is_null($pegawai->tanggal_lahir) && is_null($pegawai->status_kawin) && is_null($pegawai->alamat) && is_null($pegawai->telp_pribadi) && is_null($pegawai->kecamatan)){
            return Redirect('profile')->with(['error' => 'Untuk melihat slip gaji mohon melengkapi data diri anda terlebih dahulu!']);
        }
        // $pegawai = DB::table('pegawai')->where('pegawai_id', $pegawai_id)->first();
        $data = DB::table('penggajian')->whereNull('penggajian.deleted_at')->where('nip',$pegawai->nip)->orderBy('periode_gaji','asc')->get();
        // dd($data);
        return view('penggajian.slip_gaji.index', compact('data'));
    }
    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
        return view('penggajian.penggajian_manual.detail', compact('data','id'));
    }
    public function cetak($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
        return view('penggajian.penggajian_manual.cetak', compact('data'));
        // view()->share('data',$data);
        // $data = ['data' => $data];
        // $pdf = PDF::loadView('penggajian.penggajian_manual.cetak', $data);
        // download PDF file with download method
        // return $pdf->stream('pdf_file.pdf');
    }
    
}
