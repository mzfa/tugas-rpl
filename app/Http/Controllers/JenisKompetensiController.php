<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JenisKompetensiController extends Controller
{
    public function index()
    {
        $data = DB::table('jenis_kompetensi')->whereNull('jenis_kompetensi.deleted_at')->get();
        return view('jenis_kompetensi.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_jenis_kompetensi' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_jenis_kompetensi' => $request->nama_jenis_kompetensi,
        ];
        DB::table('jenis_kompetensi')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM jenis_kompetensi WHERE jenis_kompetensi_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama kompetensi</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_jenis_kompetensi" name="nama_jenis_kompetensi" value="'.$data[0]->nama_jenis_kompetensi.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="jenis_kompetensi_id" name="jenis_kompetensi_id" value="'.Crypt::encrypt($data[0]->jenis_kompetensi_id) .'" required>';
        }
        return $text;
        // return view('jenis_kompetensi.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_jenis_kompetensi' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_jenis_kompetensi' => $request->nama_jenis_kompetensi,
        ];
        $jenis_kompetensi_id = Crypt::decrypt($request->jenis_kompetensi_id);
        $status_kompetensi = "Aktif";
        DB::table('jenis_kompetensi')->where(['jenis_kompetensi_id' => $jenis_kompetensi_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('jenis_kompetensi')->where(['jenis_kompetensi_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
