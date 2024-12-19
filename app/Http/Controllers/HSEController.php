<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HSEController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('hse')->whereNull('hse.deleted_at')->where('hse.proyek_id', session('proyek_aktif')['id'])->get();
        return view('hse.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'tanggal' => ['required'],
            'manhours' => ['required'],
            'first_aid_injury' => ['required'],
            'medical_treatment' => ['required'],
            'fatality' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'tanggal' => $request->tanggal,
            'manhours' => $request->manhours,
            'first_aid_injury' => $request->first_aid_injury,
            'medical_treatment' => $request->medical_treatment,
            'fatality' => $request->fatality,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('hse')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM hse WHERE hse_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama hse</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_hse" name="nama_hse" value="'.$data[0]->nama_hse.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="hse_id" name="hse_id" value="'.Crypt::encrypt($data[0]->hse_id) .'" required>';
        }
        return $text;
        // return view('hse.edit');
    }

    public function update(Request $request){
        $request->validate([
            'tanggal' => ['required'],
            'manhours' => ['required'],
            'first_aid_injury' => ['required'],
            'medical_treatment' => ['required'],
            'fatality' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'tanggal' => $request->tanggal,
            'manhours' => $request->manhours,
            'first_aid_injury' => $request->first_aid_injury,
            'medical_treatment' => $request->medical_treatment,
            'fatality' => $request->fatality,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $hse_id = Crypt::decrypt($request->hse_id);
        $status_hse = "Aktif";
        DB::table('hse')->where(['hse_id' => $hse_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('hse')->where(['hse_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
