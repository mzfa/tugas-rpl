<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartementController extends Controller
{
    public function index()
    {
        $data = DB::table('departement')->whereNull('departement.deleted_at')->get();
        return view('departement.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_departement' => ['required', 'string'],
            'peran' => ['required', 'string'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_departement' => $request->nama_departement,
            'peran' => $request->peran,
        ];
        DB::table('departement')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM departement WHERE departement_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Departement</label>'.
                    '<input type="text" class="form-control" id="nama_departement" name="nama_departement" value="'.$data[0]->nama_departement.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Peran</label>'.
                '<input type="text" class="form-control" id="peran" name="peran" value="'.$data[0]->peran.'" required>'.
            '</div>'.
                '<input type="hidden" class="form-control" id="departement_id" name="departement_id" value="'.Crypt::encrypt($data[0]->departement_id) .'" required>';
        }
        return $text;
        // return view('departement.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_departement' => ['required', 'string'],
            'peran' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_departement' => $request->nama_departement,
            'peran' => $request->peran,
        ];
        $departement_id = Crypt::decrypt($request->departement_id);
        $status_departement = "Aktif";
        DB::table('departement')->where(['departement_id' => $departement_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('departement')->where(['departement_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
