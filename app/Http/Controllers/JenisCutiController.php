<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JenisCutiController extends Controller
{
    public function index()
    {
        $data = DB::table('jenis_cuti')->whereNull('jenis_cuti.deleted_at')->get();
        return view('jenis_cuti.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_jenis_cuti' => ['required'],
            'jumlah_cuti' => ['required'],
            'keterangan_cuti' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_jenis_cuti' => $request->nama_jenis_cuti,
            'jumlah_cuti' => $request->jumlah_cuti,
            'keterangan_cuti' => $request->keterangan_cuti,
        ];
        DB::table('jenis_cuti')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM jenis_cuti WHERE jenis_cuti_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama kompetensi</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_jenis_cuti" name="nama_jenis_cuti" value="'.$data[0]->nama_jenis_cuti.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="jenis_cuti_id" name="jenis_cuti_id" value="'.Crypt::encrypt($data[0]->jenis_cuti_id) .'" required>';
        }
        return $text;
        // return view('jenis_cuti.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_jenis_cuti' => ['required'],
            'jumlah_cuti' => ['required'],
            'keterangan_cuti' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_jenis_cuti' => $request->nama_jenis_cuti,
            'jumlah_cuti' => $request->jumlah_cuti,
            'keterangan_cuti' => $request->keterangan_cuti,
        ];
        $jenis_cuti_id = Crypt::decrypt($request->jenis_cuti_id);
        $status_kompetensi = "Aktif";
        DB::table('jenis_cuti')->where(['jenis_cuti_id' => $jenis_cuti_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('jenis_cuti')->where(['jenis_cuti_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
