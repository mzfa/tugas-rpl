<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MetodeController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('metode')->leftJoin('bidang_pekerjaan','metode.bidang_pekerjaan_id','bidang_pekerjaan.bidang_pekerjaan_id')->whereNull('metode.deleted_at')->where('metode.proyek_id',session('proyek_aktif')['id'])->get();
        $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
        return view('metode.index', compact('data','bidang'));
    }
    public function store(Request $request){
        $request->validate([
            'no_metode' => ['required'],
            'perihal_metode' => ['required', 'string'],
            'bidang_pekerjaan_id' => ['required'],
            'revisi_status' => ['required'],
            'status_metode' => ['required'],
            'tgl_metode' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_metode' => $request->no_metode,
            'perihal_metode' => $request->perihal_metode,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_metode' => $request->status_metode,
            'tgl_metode' => $request->tgl_metode,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('metode')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function dokumen_proses_store(Request $request){
        // dd($request);
        $request->validate([
            'tanggal_terima_dok' => ['required'],
            'status_proses_dok' => ['required'],
            'departement_id' => ['required'],
            'durasi' => ['required'],
            'catatan' => ['required'],
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'tanggal_terima_dok' => $request->tanggal_terima_dok,
            'status_proses_dok' => $request->status_proses_dok,
            'departement_id' => $request->departement_id,
            'durasi' => $request->durasi,
            'catatan' => $request->catatan,
        ];
        DB::table('dokumen_proses_metode')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM metode WHERE metode_id='$id'")){
            $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">No metode Approval</label>'.
                    '<input type="text" class="form-control" id="no_metode" name="no_metode" value="'.$data[0]->no_metode.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Perihal metode</label>'.
                    '<input type="text" class="form-control" id="perihal_metode" name="perihal_metode" value="'.$data[0]->perihal_metode.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Bidang Pekerjaan</label>'.
                    '<select required class="form-control" name="bidang_pekerjaan_id" id="bidang_pekerjaan_id">'.
                            '<option value="">Pilih Bidang</option>';
                            foreach($bidang as $item){
                                $stat = ($data[0]->bidang_pekerjaan_id == $item->bidang_pekerjaan_id) ? "selected" : "";
                                $text .= '<option value="'.$item->bidang_pekerjaan_id.'" '.$stat.'>'.$item->keterangan_bidang_pekerjaan.'</option>';
                            }
                        $text .= '</select>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Revisi Status</label>'.
                    '<select required class="form-control" name="revisi_status" id="revisi_status">'.
                        '<option value="">Pilih Revisi Status</option>';
                        $revisi1 = ($data[0]->revisi_status == "R-0") ? "selected" : "";
                        $revisi2 = ($data[0]->revisi_status == "R-1") ? "selected" : "";
                        $text .= '<option '.$revisi1.' value="R-0">R-0</option>'.
                        '<option '.$revisi2.' value="R-1">R-1</option>'.
                    '</select>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Status metode</label>'.
                    '<select required class="form-control" name="status_metode" id="status_metode">'.
                        '<option value="">Pilih Status metode</option>';
                        $revisi1 = ($data[0]->status_metode == "Open") ? "selected" : "";
                        $revisi2 = ($data[0]->status_metode == "Close") ? "selected" : "";
                        $text .= '<option '.$revisi1.' value="Open">Open</option>'.
                        '<option '.$revisi2.' value="Close">Close</option>'.
                    '</select>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tanggal Dok Meterial</label>'.
                    '<input type="date" class="form-control" id="tgl_metode" name="tgl_metode" value="'.$data[0]->tgl_metode.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="metode_id" name="metode_id" value="'.Crypt::encrypt($data[0]->metode_id) .'" required>';
        }
        return $text;
        // return view('metode.edit');
    }

    public function dokumen_proses_edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM dokumen_proses_metode WHERE dokumen_proses_metode_id='$id'")){
            $Diperiksa = ($data[0]->status_proses_dok == "Diperiksa") ? "selected" : "";
            $Disetujui = ($data[0]->status_proses_dok == "Disetujui") ? "selected" : "";
            $text = 
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Tanggal Terima Dokumen</label>'.
                        '<input type="datetime-local" class="form-control" value="'.$data[0]->tanggal_terima_dok.'" id="tanggal_terima_dok" name="tanggal_terima_dok" required>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Pihak Pemroses Dokumen</label>'.
                        '<select class="form-control" name="status_proses_dok" id="status_proses_dok">'.
                            '<option value="">Pilih Revisi Status</option>'.
                            '<option value="Diperiksa" '.$Diperiksa.'>Diperiksa</option>'.
                            '<option value="Disetujui" '.$Disetujui.'>Disetujui</option>'.
                        '</select>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Status Proses Dokumen</label>'.
                        '<select class="form-control" name="departement_id" id="departement_id">'.
                            '<option value="">Pilih Departement Pemroses</option>';
                            foreach($departement as $item){
                                $status = ($data[0]->departement_id == $item->departement_id) ? "selected" : "";
                                $text .=  '<option value="'.$item->departement_id.'" '.$status.'>'.$item->nama_departement.'</option>';
                            }
                        $text .= '</select>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Durasi (hari)</label>'.
                        '<input type="number" class="form-control" id="durasi" value="'.$data[0]->durasi.'" name="durasi" required>'.
                    '</div>'.
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Catatan</label>'.
                        '<textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control">'.$data[0]->catatan.'</textarea>'.
                    '</div>'.
                    '<input type="hidden" class="form-control" id="dokumen_proses_metode_id" name="dokumen_proses_metode_id" value="'.Crypt::encrypt($data[0]->dokumen_proses_metode_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request->perihal_metode);
        // $request->validate([
        //     'perihal_metode' => ['required'],
        //     'bidang_pekerjaan_id' => ['required'],
        //     'revisi_status' => ['required'],
        //     'status_metode' => ['required'],
        // ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'no_metode' => $request->no_metode,
            'perihal_metode' => $request->perihal_metode,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_metode' => $request->status_metode,
            'tgl_metode' => $request->tgl_metode,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $metode_id = Crypt::decrypt($request->metode_id);
        DB::table('metode')->where(['metode_id' => $metode_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function dokumen_proses_update(Request $request){
        // dd($request);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'tanggal_terima_dok' => $request->tanggal_terima_dok,
            'status_proses_dok' => $request->status_proses_dok,
            'departement_id' => $request->departement_id,
            'durasi' => $request->durasi,
            'catatan' => $request->catatan,
        ];
        $dokumen_proses_metode_id = Crypt::decrypt($request->dokumen_proses_metode_id);
        DB::table('dokumen_proses_metode')->where(['dokumen_proses_metode_id' => $dokumen_proses_metode_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('metode')->where(['metode_id' => $id])->update($data);
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
        DB::table('dokumen_proses_metode')->where(['dokumen_proses_metode_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        $data = DB::table('dokumen')->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','metode')->get();
        $data_dokumen_proses = DB::table('dokumen_proses_metode')
        ->leftJoin('users','users.id','dokumen_proses_metode.created_by')
        ->leftJoin('departement','departement.departement_id','dokumen_proses_metode.departement_id')
        ->whereNull('dokumen_proses_metode.deleted_at')
        ->get();
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();

        $idnya = '';
        foreach($data as $item){
            $idnya .= $item->dokumen_id.',';
        }
        $idnya = substr($idnya,0,-1);
        // dd($idnya);
        $data2 = DB::select("SELECT command.isi_command,users.name,command.dokumen_id FROM command LEFT JOIN users ON command.created_by = users.id where dokumen_id IN ('$idnya')");
        $commandnya = [];
        foreach($data2 as $item){
            $commandnya[$item->dokumen_id][] = [
                'isi_command' => $item->isi_command,
                'user' => $item->name
            ];
        }

        return view('metode.dokumen', compact('data','id','departement','data_dokumen_proses','commandnya'));
    }

    public function store_doc(Request $request){
        // dd('ok');
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/metode'), $file);
        }
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'link_dokumen' => $request->link_dokumen,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'jenis_dokumen_id' => $request->id,
            'jenis_dokumen' => "metode",
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
