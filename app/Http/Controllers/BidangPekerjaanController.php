<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BidangPekerjaanController extends Controller
{
    public function index()
    {
        $data = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
        return view('bidang_pekerjaan.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'kode_bidang_pekerjaan' => ['required', 'string'],
            'keterangan_bidang_pekerjaan' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kode_bidang_pekerjaan' => $request->kode_bidang_pekerjaan,
            'keterangan_bidang_pekerjaan' => $request->keterangan_bidang_pekerjaan,
        ];
        DB::table('bidang_pekerjaan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM bidang_pekerjaan WHERE bidang_pekerjaan_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama bidang_pekerjaan</label>'.
                    '<input type="text" class="form-control" id="kode_bidang_pekerjaan" name="kode_bidang_pekerjaan" value="'.$data[0]->kode_bidang_pekerjaan.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Keterangan_bidang_pekerjaan</label>'.
                '<input type="text" class="form-control" id="keterangan_bidang_pekerjaan" name="keterangan_bidang_pekerjaan" value="'.$data[0]->keterangan_bidang_pekerjaan.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="bidang_pekerjaan_id" name="bidang_pekerjaan_id" value="'.Crypt::encrypt($data[0]->bidang_pekerjaan_id) .'" required>';
        }
        return $text;
        // return view('bidang_pekerjaan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'kode_bidang_pekerjaan' => ['required', 'string'],
            'keterangan_bidang_pekerjaan' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kode_bidang_pekerjaan' => $request->kode_bidang_pekerjaan,
            'keterangan_bidang_pekerjaan' => $request->keterangan_bidang_pekerjaan,
        ];
        $bidang_pekerjaan_id = Crypt::decrypt($request->bidang_pekerjaan_id);
        $status_bidang_pekerjaan = "Aktif";
        DB::table('bidang_pekerjaan')->where(['bidang_pekerjaan_id' => $bidang_pekerjaan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('bidang_pekerjaan')->where(['bidang_pekerjaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
