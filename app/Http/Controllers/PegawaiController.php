<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Exports\ExportUsers;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = DB::table('pegawai')->whereNull('pegawai.deleted_at')->leftJoin('departement', 'pegawai.departement_id', '=', 'departement.departement_id')->get();
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        return view('pegawai.index', compact('data','departement'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM pegawai WHERE pegawai_id='$id'")){
            $text = 
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Nama Pegawai</label>'.
                        '<input type="text" class="form-control" value="'.$data[0]->nama_pegawai.'" id="nama_pegawai" name="nama_pegawai" required>'.
                    '</div>'.
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Status Proses Dokumen</label>'.
                        '<select class="form-control" name="departement_id" id="departement_id">'.
                            '<option value="">Pilih Departement</option>';
                            foreach($departement as $item){
                                $status = ($data[0]->departement_id == $item->departement_id) ? "selected" : "";
                                $text .=  '<option value="'.$item->departement_id.'" '.$status.'>'.$item->nama_departement.'</option>';
                            }
                        $text .= '</select>'.
                    '</div>'.
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Email</label>'.
                        '<input type="email" class="form-control" value="'.$data[0]->email.'" id="email" name="email" required>'.
                    '</div>'.
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Telepon</label>'.
                        '<input type="text" class="form-control" value="'.$data[0]->telp.'" id="telp" name="telp" required>'.
                    '</div>'.
                    '<input type="hidden" class="form-control" id="pegawai_id" name="pegawai_id" value="'.Crypt::encrypt($data[0]->pegawai_id) .'" required>';
        }
        return $text;
    }

    public function add()
    {
        $struktur = DB::table('struktur')->get();
        $bagian = DB::table('bagian')->get();
        $profesi = DB::table('profesi')->get();
        return view('pegawai.add', compact('struktur','bagian','profesi'));
    }

    public function store(Request $request){
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_pegawai' => $request->nama_pegawai,
            'departement_id' => $request->departement_id,
            'email' => $request->email,
            'telp' => $request->telp,
        ];
        // dd($data);
        DB::table('pegawai')->insert($data);
        // return true;
        return Redirect('pegawai')->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function update(Request $request){
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_pegawai' => $request->nama_pegawai,
            'departement_id' => $request->departement_id,
            'email' => $request->email,
            'telp' => $request->telp,
        ];
        $pegawai_id = Crypt::decrypt($request->pegawai_id);
        DB::table('pegawai')->where(['pegawai_id' => $pegawai_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pegawai')->where(['pegawai_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
