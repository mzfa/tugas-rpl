<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GrupKepegawaianController extends Controller
{
    public function index()
    {
        $data = DB::table('grup_kepegawaian')->whereNull('grup_kepegawaian.deleted_at')->get();
        return view('grup_kepegawaian.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_grup_kepegawaian' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_grup_kepegawaian' => $request->nama_grup_kepegawaian,
        ];
        DB::table('grup_kepegawaian')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM grup_kepegawaian WHERE grup_kepegawaian_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Jenis Pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_grup_kepegawaian" name="nama_grup_kepegawaian" value="'.$data[0]->nama_grup_kepegawaian.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="grup_kepegawaian_id" name="grup_kepegawaian_id" value="'.Crypt::encrypt($data[0]->grup_kepegawaian_id) .'" required>';
        }
        return $text;
        // return view('grup_kepegawaian.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_grup_kepegawaian' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_grup_kepegawaian' => $request->nama_grup_kepegawaian,
        ];
        $grup_kepegawaian_id = Crypt::decrypt($request->grup_kepegawaian_id);
        $status_grup_kepegawaian = "Aktif";
        DB::table('grup_kepegawaian')->where(['grup_kepegawaian_id' => $grup_kepegawaian_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('grup_kepegawaian')->where(['grup_kepegawaian_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
