<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File; 

class PelatihanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $data = DB::table('pelatihan')
            ->leftJoin('jenis_pelatihan','pelatihan.jenis_pelatihan_id','jenis_pelatihan.jenis_pelatihan_id')
            ->whereNull('pelatihan.deleted_at')->where(['pelatihan.created_by' => $id])->get();
        $jenis_pelatihan = DB::table('jenis_pelatihan')->whereNull('jenis_pelatihan.deleted_at')->get();
        return view('pelatihan.index', compact('data','jenis_pelatihan'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_pelatihan' => ['required'],
            'tanggal_pelatihan' => ['required'],
            'bukti_pelatihan' => 'required|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);
        // dd($request);
        if($request->hasFile('bukti_pelatihan')){
            $bukti_pelatihan = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('bukti_pelatihan')->getClientOriginalName());
            $name = Auth::user()->pegawai_id;
            // dd($bukti_pelatihan);
            $request->file('bukti_pelatihan')->move(public_path('document/pelatihan/'), $bukti_pelatihan);
            $data = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'nama_pelatihan' => $request->nama_pelatihan,
                'jenis_pelatihan_id' => $request->jenis_pelatihan_id,
                'tanggal_pelatihan' => $request->tanggal_pelatihan,
                'penyelenggara' => $request->penyelenggara,
                'bukti_pelatihan' => $bukti_pelatihan,
            ];
            DB::table('pelatihan')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
        }
        return Redirect::back()->with(['error' => 'Data Gagal Disimpan dikarenakan SK yang anda upload tidak sesuai!']);

    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        // sleep(3);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM pelatihan WHERE pelatihan_id='$id'")){
            $jenis_pelatihan = DB::table('jenis_pelatihan')->whereNull('jenis_pelatihan.deleted_at')->get();
            $text = '<a class="btn btn-primary btn-block mb-3" href="/document/pelatihan/'.$data[0]->bukti_pelatihan.'" target="_blank">Lihat Bukti</a>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_pelatihan" name="nama_pelatihan" value="'.$data[0]->nama_pelatihan.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Jenis pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<select class="form-control" name="jenis_pelatihan_id" id="jenis_pelatihan_id" required>';
                        foreach($jenis_pelatihan as $item){
                            $text .= '<option value="'. $item->jenis_pelatihan_id .'">'.$item->nama_jenis_pelatihan.'</option>';
                        }
                $text .= '</select>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tanggal pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="date" class="form-control" id="tanggal_pelatihan" name="tanggal_pelatihan" value="'.$data[0]->tanggal_pelatihan.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Penyelenggara</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="'.$data[0]->penyelenggara.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Bukti Pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="file" class="form-control" id="bukti_pelatihan" name="bukti_pelatihan" value="'.$data[0]->bukti_pelatihan.'" accept="image/*">'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="image" name="image" value="'.$data[0]->bukti_pelatihan.'" required>'.
                '<input type="hidden" class="form-control" id="pelatihan_id" name="pelatihan_id" value="'.Crypt::encrypt($data[0]->pelatihan_id) .'" required>';
        }
        return $text;
        // return view('pelatihan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_pelatihan' => ['required'],
            'tanggal_pelatihan' => ['required'],
            // 'bukti_pelatihan' => 'mimes:jpeg,jpg,png,PNG,gif,svg|max:2048'
        ]);
        $bukti_pelatihan = $request->file;
        if($request->hasFile('bukti_pelatihan')){
            $fileLama = public_path('document/pelatihan/'.$request->image);
            File::delete($fileLama);
            $bukti_pelatihan = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('bukti_pelatihan')->getClientOriginalName());
            $request->file('bukti_pelatihan')->move(public_path('document/pelatihan/'), $bukti_pelatihan);
        }
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_pelatihan' => $request->nama_pelatihan,
            'jenis_pelatihan_id' => $request->jenis_pelatihan_id,
            'bukti_pelatihan' => $bukti_pelatihan,
            'tanggal_pelatihan' => $request->tanggal_pelatihan,
        ];
        $pelatihan_id = Crypt::decrypt($request->pelatihan_id);
        DB::table('pelatihan')->where(['pelatihan_id' => $pelatihan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pelatihan')->where(['pelatihan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
