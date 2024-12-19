<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JasaMedisController extends Controller
{
    public function index()
    {
        $data = DB::table('jasa_medis')->leftJoin('pegawai', 'jasa_medis.pegawai_id', 'pegawai.pegawai_id')->whereNull('jasa_medis.deleted_at')->get();
        return view('penggajian.jasa_medis.index', compact('data'));
    }
    public function add()
    {
        // dd($_GET['periode']);
        $periode = $_GET['periode'];
        $data = DB::table('pegawai')->select('pegawai.*','jasa_medis.file_bukti')->leftJoin('jasa_medis', 'jasa_medis.pegawai_id', 'pegawai.pegawai_id')->whereNull('pegawai.deleted_at')->where('profesi_id', 16)->get();
        // dd($data);
        return view('penggajian.jasa_medis.add', compact('data','periode'));
    }
    public function store(Request $request){
        // dd($request->file('file'));
        $request->validate([
            'periode' => ['required'],
        ]);
        // dd($request);
        $periode = str_replace("-",'', $request->periode);
        $no = 0;
        $file = $request->file('file');
        foreach($file as $key => $item){
            $pegawai_id= $request->pegawai_id[$key];
            DB::table('jasa_medis')->where(['pegawai_id' => $pegawai_id,'periode_pembayaran' => $periode])->delete();
            if($item){
                $bukti_pelatihan = round(microtime(true) * 1000).'-'.str_replace(' ','-',$item->getClientOriginalName());
                $bukti_pelatihan = $periode.'-'.$item->getClientOriginalName();
                // dump($bukti_pelatihan);
                $item->move(public_path('document/jasa_medis/'.$pegawai_id.'/'), $bukti_pelatihan);
                // $pegawai_id = Crypt::decrypt($request->pegawai_id);
                $data = [
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'periode_pembayaran' => $periode,
                    'file_bukti' => $bukti_pelatihan,
                    'pegawai_id' => $pegawai_id,
                ];
                // dump($data);
                DB::table('jasa_medis')->insert($data);
                // return true;
            }
        }
        return Redirect::to('jasa_medis')->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM jasa_medis WHERE jasa_medis_id='$id'")){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Jenis Pelatihan</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_jasa_medis" name="nama_jasa_medis" value="'.$data[0]->nama_jasa_medis.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="jasa_medis_id" name="jasa_medis_id" value="'.Crypt::encrypt($data[0]->jasa_medis_id) .'" required>';
        }
        return $text;
        // return view('penggajian.jasa_medis.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_jasa_medis' => ['required', 'string'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_jasa_medis' => $request->nama_jasa_medis,
        ];
        $jasa_medis_id = Crypt::decrypt($request->jasa_medis_id);
        $status_jasa_medis = "Aktif";
        DB::table('jasa_medis')->where(['jasa_medis_id' => $jasa_medis_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('jasa_medis')->where(['jasa_medis_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
