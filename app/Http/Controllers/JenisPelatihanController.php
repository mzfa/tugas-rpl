<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JenisPelatihanController extends Controller
{
    public function index()
    {
        $data = DB::table('jenis_pelatihan')->whereNull('jenis_pelatihan.deleted_at')->get();
        return view('jenis_pelatihan.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_jenis_pelatihan' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_jenis_pelatihan' => $request->nama_jenis_pelatihan,
        ];
        DB::table('jenis_pelatihan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM jenis_pelatihan WHERE jenis_pelatihan_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Jenis Pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_jenis_pelatihan" name="nama_jenis_pelatihan" value="'.$data[0]->nama_jenis_pelatihan.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="jenis_pelatihan_id" name="jenis_pelatihan_id" value="'.Crypt::encrypt($data[0]->jenis_pelatihan_id) .'" required>';
        }
        return $text;
        // return view('jenis_pelatihan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_jenis_pelatihan' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_jenis_pelatihan' => $request->nama_jenis_pelatihan,
        ];
        $jenis_pelatihan_id = Crypt::decrypt($request->jenis_pelatihan_id);
        $status_jenis_pelatihan = "Aktif";
        DB::table('jenis_pelatihan')->where(['jenis_pelatihan_id' => $jenis_pelatihan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('jenis_pelatihan')->where(['jenis_pelatihan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
