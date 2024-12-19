<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KategoriSuratController extends Controller
{
    public function index()
    {
        $data = DB::table('kategori_surat')->whereNull('kategori_surat.deleted_at')->get();
        return view('kategori_surat.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'kode_kategori_surat' => ['required', 'string'],
            'keterangan_kategori_surat' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kode_kategori_surat' => $request->kode_kategori_surat,
            'keterangan_kategori_surat' => $request->keterangan_kategori_surat,
        ];
        DB::table('kategori_surat')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM kategori_surat WHERE kategori_surat_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Kategori Surat</label>'.
                    '<input type="text" class="form-control" id="kode_kategori_surat" name="kode_kategori_surat" value="'.$data[0]->kode_kategori_surat.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Keterangan Kategori Surat</label>'.
                '<input type="text" class="form-control" id="keterangan_kategori_surat" name="keterangan_kategori_surat" value="'.$data[0]->keterangan_kategori_surat.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="kategori_surat_id" name="kategori_surat_id" value="'.Crypt::encrypt($data[0]->kategori_surat_id) .'" required>';
        }
        return $text;
        // return view('kategori_surat.edit');
    }

    public function update(Request $request){
        $request->validate([
            'kode_kategori_surat' => ['required', 'string'],
            'keterangan_kategori_surat' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kode_kategori_surat' => $request->kode_kategori_surat,
            'keterangan_kategori_surat' => $request->keterangan_kategori_surat,
        ];
        $kategori_surat_id = Crypt::decrypt($request->kategori_surat_id);
        $status_kategori_surat = "Aktif";
        DB::table('kategori_surat')->where(['kategori_surat_id' => $kategori_surat_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('kategori_surat')->where(['kategori_surat_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
