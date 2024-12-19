<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PekerjaanController extends Controller
{
    public function index()
    {
        $data = DB::table('pekerjaan')->whereNull('pekerjaan.deleted_at')->get();
        return view('pekerjaan.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_pekerjaan' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ];
        DB::table('pekerjaan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM pekerjaan WHERE pekerjaan_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama pekerjaan</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" value="'.$data[0]->nama_pekerjaan.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="pekerjaan_id" name="pekerjaan_id" value="'.Crypt::encrypt($data[0]->pekerjaan_id) .'" required>';
        }
        return $text;
        // return view('pekerjaan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_pekerjaan' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ];
        $pekerjaan_id = Crypt::decrypt($request->pekerjaan_id);
        $status_pekerjaan = "Aktif";
        DB::table('pekerjaan')->where(['pekerjaan_id' => $pekerjaan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pekerjaan')->where(['pekerjaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
