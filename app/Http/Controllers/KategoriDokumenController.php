<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KategoriDokumenController extends Controller
{
    public function index()
    {
        $data = DB::table('kategori_dokumen')->whereNull('kategori_dokumen.deleted_at')->get();
        return view('kategori_dokumen.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'kode_kategori_dokumen' => ['required', 'string'],
            'keterangan_kategori_dokumen' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kode_kategori_dokumen' => $request->kode_kategori_dokumen,
            'keterangan_kategori_dokumen' => $request->keterangan_kategori_dokumen,
        ];
        DB::table('kategori_dokumen')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM kategori_dokumen WHERE kategori_dokumen_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Kategori Dokumen</label>'.
                    '<input type="text" class="form-control" id="kode_kategori_dokumen" name="kode_kategori_dokumen" value="'.$data[0]->kode_kategori_dokumen.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Keterangan Kategori Dokumen</label>'.
                '<input type="text" class="form-control" id="keterangan_kategori_dokumen" name="keterangan_kategori_dokumen" value="'.$data[0]->keterangan_kategori_dokumen.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="kategori_dokumen_id" name="kategori_dokumen_id" value="'.Crypt::encrypt($data[0]->kategori_dokumen_id) .'" required>';
        }
        return $text;
        // return view('kategori_dokumen.edit');
    }

    public function update(Request $request){
        $request->validate([
            'kode_kategori_dokumen' => ['required', 'string'],
            'keterangan_kategori_dokumen' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kode_kategori_dokumen' => $request->kode_kategori_dokumen,
            'keterangan_kategori_dokumen' => $request->keterangan_kategori_dokumen,
        ];
        $kategori_dokumen_id = Crypt::decrypt($request->kategori_dokumen_id);
        $status_kategori_dokumen = "Aktif";
        DB::table('kategori_dokumen')->where(['kategori_dokumen_id' => $kategori_dokumen_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('kategori_dokumen')->where(['kategori_dokumen_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
