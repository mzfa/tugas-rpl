<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProgressController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $proyek_aktif = session('proyek_aktif')['id'];
        $data = DB::select(DB::raw("select
                    progress.progress_id,
                    progress.minggu_ke,
                    progress.start,
                    progress.finish,
                    sum(progress_detail.bobot) as bobot,
                    sum(progress_detail.bobot_rencana) as bobot_rencana,
                    sum(progress_detail.bobot_sd_minggu_ini) as realisasi_mingguan,
                    sum(progress_detail.bobot) - sum(progress_detail.bobot_sd_minggu_ini) as deviasi
                from
                    progress
                left join progress_detail on
                    progress_detail.progress_id = progress.progress_id
                    and progress_detail.deleted_by is null
                where
                    progress.deleted_at is null
                    and progress.proyek_id = '$proyek_aktif'
                group by
                    progress.progress_id,
                    minggu_ke,
                    start,
                    finish,
                    progress_detail.bobot,
                    progress_detail.bobot_rencana,
                    progress_detail.bobot_minggu_ini"));
                // dd($data);
        return view('progress.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'minggu_ke' => ['required'],
            'start' => ['required'],
            'finish' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'minggu_ke' => $request->minggu_ke,
            'start' => $request->start,
            'finish' => $request->finish,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('progress')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function progress_detail_store(Request $request){
        $request->validate([
            'jenis_pekerjaan_id' => ['required'],
            'bobot' => ['required'],
            'bobot_rencana' => ['required'],
            'prestasi_minggu_lalu' => ['required'],
            'bobot_minggu_lalu' => ['required'],
            'prestasi_minggu_ini' => ['required'],
            'bobot_minggu_ini' => ['required'],
            'prestasi_sd_minggu_ini' => ['required'],
            'bobot_sd_minggu_ini' => ['required'],
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'progress_id' => $request->progress_id,
            'jenis_pekerjaan_id' => $request->jenis_pekerjaan_id,
            'bobot' => $request->bobot,
            'bobot_rencana' => $request->bobot_rencana,
            'prestasi_minggu_lalu' => $request->prestasi_minggu_lalu,
            'bobot_minggu_lalu' => $request->bobot_minggu_lalu,
            'prestasi_minggu_ini' => $request->prestasi_minggu_ini,
            'bobot_minggu_ini' => $request->bobot_minggu_ini,
            'prestasi_sd_minggu_ini' => $request->prestasi_sd_minggu_ini,
            'bobot_sd_minggu_ini' => $request->bobot_sd_minggu_ini,
        ];
        DB::table('progress_detail')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM progress WHERE progress_id='$id'")){
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Minggu Ke</label>'.
                    '<input type="text" class="form-control" id="minggu_ke" name="minggu_ke" value="'.$data[0]->minggu_ke.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Start</label>'.
                    '<input type="date" class="form-control" id="start" name="start" value="'.$data[0]->start.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Finish</label>'.
                    '<input type="date" class="form-control" id="finish" name="finish" value="'.$data[0]->finish.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="progress_id" name="progress_id" value="'.Crypt::encrypt($data[0]->progress_id) .'" required>';
        }
        return $text;
        // return view('progress.edit');
    }

    public function progres_detail_edit($id)
    {
        // return 'ok';
        $jenis_pekerjaan = DB::table('jenis_pekerjaan')->whereNull('jenis_pekerjaan.deleted_at')->get();
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM progress_detail WHERE progress_detail_id='$id'")){
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Jenis Pekerjaan</label>'.
                    '<select name="jenis_pekerjaan_id" id="" class="form-select" required>'.
                        '<option value=""></option>';
                        foreach($jenis_pekerjaan as $item):
                        $status = ($item->jenis_pekerjaan_id==$data[0]->jenis_pekerjaan_id) ? 'selected' : '';
                        $text .= '<option value="'. $item->jenis_pekerjaan_id .'" '. $status .' >'. $item->nama_jenis_pekerjaan .'</option>';
                        endforeach;
                        $text .= '</select>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Bobot (%)</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->bobot.'" id="bobot" name="bobot" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Bobot Rencana (%)</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->bobot_rencana.'" id="bobot_rencana" name="bobot_rencana" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Prestasi Minggu Lalu</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->prestasi_minggu_lalu.'" id="prestasi_minggu_lalu" name="prestasi_minggu_lalu" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Bobot Minggu Lalu</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->bobot_minggu_lalu.'" id="bobot_minggu_lalu" name="bobot_minggu_lalu" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Prestasi Minggu Ini</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->prestasi_minggu_ini.'" id="prestasi_minggu_ini" name="prestasi_minggu_ini" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Bobot Minggu Ini</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->bobot_minggu_ini.'" id="bobot_minggu_ini" name="bobot_minggu_ini" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Prestasi s/d Minggu Ini</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->prestasi_sd_minggu_ini.'" id="prestasi_sd_minggu_ini" name="prestasi_sd_minggu_ini" required>'.
                '</div>'.
                '<div class="col-6 mb-3">'.
                    '<label for="staticEmail" class="form-label">Bobot s/d Minggu Ini</label>'.
                    '<input type="text" class="form-control" value="'.$data[0]->bobot_sd_minggu_ini.'" id="bobot_sd_minggu_ini" name="bobot_sd_minggu_ini" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="progress_detail_id" name="progress_detail_id" value="'.Crypt::encrypt($data[0]->progress_detail_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request->start);
        // $request->validate([
        //     'start' => ['required'],
        //     'bidang_pekerjaan_id' => ['required'],
        //     'revisi_status' => ['required'],
        //     'status_material' => ['required'],
        // ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'minggu_ke' => $request->minggu_ke,
            'start' => $request->start,
            'finish' => $request->finish,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $progress_id = Crypt::decrypt($request->progress_id);
        DB::table('progress')->where(['progress_id' => $progress_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function progres_detail_update(Request $request){
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'jenis_pekerjaan_id' => $request->jenis_pekerjaan_id,
            'bobot' => $request->bobot,
            'bobot_rencana' => $request->bobot_rencana,
            'prestasi_minggu_lalu' => $request->prestasi_minggu_lalu,
            'bobot_minggu_lalu' => $request->bobot_minggu_lalu,
            'prestasi_minggu_ini' => $request->prestasi_minggu_ini,
            'bobot_minggu_ini' => $request->bobot_minggu_ini,
            'prestasi_sd_minggu_ini' => $request->prestasi_sd_minggu_ini,
            'bobot_sd_minggu_ini' => $request->bobot_sd_minggu_ini,
        ];

        $progress_detail_id = Crypt::decrypt($request->progress_detail_id);
        DB::table('progress_detail')->where(['progress_detail_id' => $progress_detail_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('progress')->where(['progress_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function delete_doc($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('dokumen')->where(['dokumen_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function delete_proses_store($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('progress_detail')->where(['progress_detail_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        $data = DB::table('dokumen')->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','progress')->get();
        $progress_detail = DB::table('progress_detail')->leftJoin('jenis_pekerjaan','progress_detail.jenis_pekerjaan_id','jenis_pekerjaan.jenis_pekerjaan_id')->where('progress_id',$id)->whereNull('progress_detail.deleted_at')->get();
        $jenis_pekerjaan = DB::table('jenis_pekerjaan')->whereNull('jenis_pekerjaan.deleted_at')->get();
        return view('progress.dokumen', compact('data','id','progress_detail','jenis_pekerjaan'));
    }

    public function store_doc(Request $request){
        // dd('ok');
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/surat'), $file);
        }
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'link_dokumen' => $request->link_dokumen,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'jenis_dokumen_id' => $request->id,
            'jenis_dokumen' => "progress",
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
