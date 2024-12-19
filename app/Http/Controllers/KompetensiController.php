<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Facade\FlareClient\Stacktrace\File;

class KompetensiController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $data = DB::table('kompetensi')->whereNull('kompetensi.deleted_at')->where(['kompetensi.created_by' => $id])->get();
        $jenis_kompetensi = DB::table('jenis_kompetensi')->whereNull('jenis_kompetensi.deleted_at')->get();
        return view('kompetensi.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_kompetensi' => ['required'],
            'jenis_kompetensi' => ['required'],
            'tmt' => ['required'],
            'smpt' => ['required'],
            'berakhir' => ['required'],
            'no_sk' => ['required'],
            'bukti_sk' => 'required|mimes:pdf|max:2048'
        ]);
        // dd($request);
        if($request->hasFile('bukti_sk')){
            $bukti_sk = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('bukti_sk')->getClientOriginalName());
            $name = Auth::user()->pegawai_id;
            // dd($bukti_sk);
            $request->file('bukti_sk')->move(public_path('document/sk/'), $bukti_sk);
            $data = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'nama_kompetensi' => $request->nama_kompetensi,
                'jenis_kompetensi' => $request->jenis_kompetensi,
                'tmt' => $request->tmt,
                'smpt' => $request->smpt,
                'berakhir' => $request->berakhir,
                'no_sk' => $request->no_sk,
                'bukti_sk' => $bukti_sk,
            ];
            DB::table('kompetensi')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
        }
        return Redirect::back()->with(['error' => 'Data Gagal Disimpan dikarenakan SK yang anda upload tidak sesuai!']);

    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM kompetensi WHERE kompetensi_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama kompetensi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_kompetensi" name="nama_kompetensi" value="'.$data[0]->nama_kompetensi.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama kompetensi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="jenis_kompetensi" name="jenis_kompetensi" value="'.$data[0]->jenis_kompetensi.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama kompetensi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tmt" name="tmt" value="'.$data[0]->tmt.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">SMPT</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="smpt" name="smpt" value="'.$data[0]->smpt.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Berakhir</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="berakhir" name="berakhir" value="'.$data[0]->berakhir.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nomor SK</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="no_sk" name="no_sk" value="'.$data[0]->no_sk.'" required readonly disabled>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="kompetensi_id" name="kompetensi_id" value="'.Crypt::encrypt($data[0]->kompetensi_id) .'" required>';
        }
        return $text;
        // return view('kompetensi.edit');
    }

    // public function update(Request $request){
    //     $request->validate([
    //         'nama_kompetensi' => ['required', 'string'],
    //     ]);
    //     $data = [
    //         'updated_by' => Auth::user()->id,
    //         'updated_at' => now(),
    //         'nama_kompetensi' => $request->nama_kompetensi,
    //     ];
    //     $kompetensi_id = Crypt::decrypt($request->kompetensi_id);
    //     $status_kompetensi = "Aktif";
    //     DB::table('kompetensi')->where(['kompetensi_id' => $kompetensi_id])->update($data);
    //     return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    // }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('kompetensi')->where(['kompetensi_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
