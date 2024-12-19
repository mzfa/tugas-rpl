<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StatusDokumenController extends Controller
{
    public function index()
    {
        $data = DB::table('status_dokumen')->whereNull('status_dokumen.deleted_at')->get();
        return view('status_dokumen.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'kode_status_dokumen' => ['required', 'string'],
            'keterangan_status_dokumen' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kode_status_dokumen' => $request->kode_status_dokumen,
            'keterangan_status_dokumen' => $request->keterangan_status_dokumen,
        ];
        DB::table('status_dokumen')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM status_dokumen WHERE status_dokumen_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Kategori Surat</label>'.
                    '<input type="text" class="form-control" id="kode_status_dokumen" name="kode_status_dokumen" value="'.$data[0]->kode_status_dokumen.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Keterangan Kategori Surat</label>'.
                '<input type="text" class="form-control" id="keterangan_status_dokumen" name="keterangan_status_dokumen" value="'.$data[0]->keterangan_status_dokumen.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="status_dokumen_id" name="status_dokumen_id" value="'.Crypt::encrypt($data[0]->status_dokumen_id) .'" required>';
        }
        return $text;
        // return view('status_dokumen.edit');
    }

    public function update(Request $request){
        $request->validate([
            'kode_status_dokumen' => ['required', 'string'],
            'keterangan_status_dokumen' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kode_status_dokumen' => $request->kode_status_dokumen,
            'keterangan_status_dokumen' => $request->keterangan_status_dokumen,
        ];
        $status_dokumen_id = Crypt::decrypt($request->status_dokumen_id);
        $status_status_dokumen = "Aktif";
        DB::table('status_dokumen')->where(['status_dokumen_id' => $status_dokumen_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('status_dokumen')->where(['status_dokumen_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
