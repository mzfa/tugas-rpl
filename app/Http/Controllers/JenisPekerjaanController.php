<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JenisPekerjaanController extends Controller
{
    public function index()
    {
        $data = DB::table('jenis_pekerjaan')->whereNull('jenis_pekerjaan.deleted_at')->get();
        return view('jenis_pekerjaan.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_jenis_pekerjaan' => ['required', 'string'],
            'keterangan' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_jenis_pekerjaan' => $request->nama_jenis_pekerjaan,
            'keterangan' => $request->keterangan,
        ];
        DB::table('jenis_pekerjaan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM jenis_pekerjaan WHERE jenis_pekerjaan_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Jenis Pekerjaan</label>'.
                    '<input type="text" class="form-control" id="nama_jenis_pekerjaan" name="nama_jenis_pekerjaan" value="'.$data[0]->nama_jenis_pekerjaan.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">keterangan</label>'.
                '<input type="text" class="form-control" id="keterangan" name="keterangan" value="'.$data[0]->keterangan.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" value="'.Crypt::encrypt($data[0]->jenis_pekerjaan_id) .'" required>';
        }
        return $text;
        // return view('jenis_pekerjaan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_jenis_pekerjaan' => ['required', 'string'],
            'keterangan' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_jenis_pekerjaan' => $request->nama_jenis_pekerjaan,
            'keterangan' => $request->keterangan,
        ];
        $jenis_pekerjaan_id = Crypt::decrypt($request->jenis_pekerjaan_id);
        $status_jenis_pekerjaan = "Aktif";
        DB::table('jenis_pekerjaan')->where(['jenis_pekerjaan_id' => $jenis_pekerjaan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('jenis_pekerjaan')->where(['jenis_pekerjaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
