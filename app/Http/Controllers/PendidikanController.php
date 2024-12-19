<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PendidikanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $data = DB::table('pendidikan')->leftJoin('jenis_pendidikan', 'pendidikan.jenis_pendidikan_id', '=', 'jenis_pendidikan.jenis_pendidikan_id')->whereNull('pendidikan.deleted_at')->where(['pendidikan.created_by' => $id])->get();
        $pendidikan = DB::table('jenis_pendidikan')->whereNull('jenis_pendidikan.deleted_at')->get();
        $jurusan = DB::table('pendidikan')->distinct()->get(['jurusan']);
        return view('pendidikan.index', compact('data','pendidikan','jurusan'));
    }
    public function store(Request $request){
        $request->validate([
            'jenis_pendidikan_id' => ['required'],
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'jenis_pendidikan_id' => $request->jenis_pendidikan_id,
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        DB::table('pendidikan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM pendidikan WHERE pendidikan_id='$id'")){
            $jurusan = DB::table('pendidikan')->distinct()->get(['jurusan']);

            $text = '<div class="mb-3 row">'.
                '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Instansi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="'.$data[0]->nama_instansi.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Jurusan/Fakultas</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" list="datalistjurusan" name="jurusan" class="form-control" id="address4" value="'.$data[0]->jurusan.'" placeholder="Select Jurusan">'.
                            '<datalist id="datalistjurusan">';
                                foreach($jurusan as $item){
                                    $text .= '<option value="'.$item->jurusan.'">';
                                }
                            $text .='</datalist>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Mulai</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_mulai" name="tahun_mulai" value="'.$data[0]->tahun_mulai.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Lulus</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="'.$data[0]->tahun_lulus.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="pendidikan_id" name="pendidikan_id" value="'.Crypt::encrypt($data[0]->pendidikan_id) .'" required>';
        }
        return $text;
        // return view('pendidikan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        $pendidikan_id = Crypt::decrypt($request->pendidikan_id);
        $status_pendidikan = "Aktif";
        DB::table('pendidikan')->where(['pendidikan_id' => $pendidikan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pendidikan')->where(['pendidikan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
