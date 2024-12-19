<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KategoriStatusController extends Controller
{
    public function index()
    {
        $data = DB::table('kategori_status')->whereNull('kategori_status.deleted_at')->get();
        return view('kategori_status.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_kategori_status' => ['required', 'string'],
            'keterangan' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_kategori_status' => $request->nama_kategori_status,
            'keterangan' => $request->keterangan,
        ];
        DB::table('kategori_status')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM kategori_status WHERE kategori_status_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama kategori_status</label>'.
                    '<input type="text" class="form-control" id="nama_kategori_status" name="nama_kategori_status" value="'.$data[0]->nama_kategori_status.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Keterangan</label>'.
                '<input type="text" class="form-control" id="keterangan" name="keterangan" value="'.$data[0]->keterangan.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="kategori_status_id" name="kategori_status_id" value="'.Crypt::encrypt($data[0]->kategori_status_id) .'" required>';
        }
        return $text;
        // return view('kategori_status.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_kategori_status' => ['required', 'string'],
            'keterangan' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_kategori_status' => $request->nama_kategori_status,
            'keterangan' => $request->keterangan,
        ];
        $kategori_status_id = Crypt::decrypt($request->kategori_status_id);
        $status_kategori_status = "Aktif";
        DB::table('kategori_status')->where(['kategori_status_id' => $kategori_status_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('kategori_status')->where(['kategori_status_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
