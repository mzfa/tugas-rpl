<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class IjinPelaksanaanController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('ijin_pelaksanaan')->leftJoin('bidang_pekerjaan','ijin_pelaksanaan.bidang_pekerjaan_id','bidang_pekerjaan.bidang_pekerjaan_id')->whereNull('ijin_pelaksanaan.deleted_at')->where('ijin_pelaksanaan.proyek_id',session('proyek_aktif')['id'])->get();
        $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
        return view('ijin_pelaksanaan.index', compact('data','bidang'));
    }
    public function store(Request $request){
        // dd($request);
        $request->validate([
            'no_ijin_pelaksanaan' => ['required'],
            'perihal_ijin_pelaksanaan' => ['required', 'string'],
            'bidang_pekerjaan_id' => ['required'],
            'revisi_status' => ['required'],
            'status_ijin_pelaksanaan' => ['required'],
            'tgl_ijin_pelaksanaan' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_ijin_pelaksanaan' => $request->no_ijin_pelaksanaan,
            'perihal_ijin_pelaksanaan' => $request->perihal_ijin_pelaksanaan,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_ijin_pelaksanaan' => $request->status_ijin_pelaksanaan,
            'tgl_ijin_pelaksanaan' => $request->tgl_ijin_pelaksanaan,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('ijin_pelaksanaan')->insert($data);
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
        DB::table('dokumen_proses_ijin_pelaksanaan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM ijin_pelaksanaan WHERE ijin_pelaksanaan_id='$id'")){
            $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">No ijin_pelaksanaan Approval</label>'.
                    '<input type="text" class="form-control" id="no_ijin_pelaksanaan" name="no_ijin_pelaksanaan" value="'.$data[0]->no_ijin_pelaksanaan.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Perihal ijin_pelaksanaan</label>'.
                    '<input type="text" class="form-control" id="perihal_ijin_pelaksanaan" name="perihal_ijin_pelaksanaan" value="'.$data[0]->perihal_ijin_pelaksanaan.'" required>'.
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
                    '<label for="staticEmail" class="form-label">Status ijin_pelaksanaan</label>'.
                    '<select required class="form-control" name="status_ijin_pelaksanaan" id="status_ijin_pelaksanaan">'.
                        '<option value="">Pilih Status ijin_pelaksanaan</option>';
                        $revisi1 = ($data[0]->status_ijin_pelaksanaan == "Open") ? "selected" : "";
                        $revisi2 = ($data[0]->status_ijin_pelaksanaan == "Close") ? "selected" : "";
                        $text .= '<option '.$revisi1.' value="Open">Open</option>'.
                        '<option '.$revisi2.' value="Close">Close</option>'.
                    '</select>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tanggal Dok Meterial</label>'.
                    '<input type="date" class="form-control" id="tgl_ijin_pelaksanaan" name="tgl_ijin_pelaksanaan" value="'.$data[0]->tgl_ijin_pelaksanaan.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="ijin_pelaksanaan_id" name="ijin_pelaksanaan_id" value="'.Crypt::encrypt($data[0]->ijin_pelaksanaan_id) .'" required>';
        }
        return $text;
        // return view('ijin_pelaksanaan.edit');
    }

    public function dokumen_proses_edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM dokumen_proses_ijin_pelaksanaan WHERE dokumen_proses_ijin_pelaksanaan_id='$id'")){
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
                    '<input type="hidden" class="form-control" id="dokumen_proses_ijin_pelaksanaan_id" name="dokumen_proses_ijin_pelaksanaan_id" value="'.Crypt::encrypt($data[0]->dokumen_proses_ijin_pelaksanaan_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request->perihal_ijin_pelaksanaan);
        // $request->validate([
        //     'perihal_ijin_pelaksanaan' => ['required'],
        //     'bidang_pekerjaan_id' => ['required'],
        //     'revisi_status' => ['required'],
        //     'status_ijin_pelaksanaan' => ['required'],
        // ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'no_ijin_pelaksanaan' => $request->no_ijin_pelaksanaan,
            'perihal_ijin_pelaksanaan' => $request->perihal_ijin_pelaksanaan,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_ijin_pelaksanaan' => $request->status_ijin_pelaksanaan,
            'tgl_ijin_pelaksanaan' => $request->tgl_ijin_pelaksanaan,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $ijin_pelaksanaan_id = Crypt::decrypt($request->ijin_pelaksanaan_id);
        DB::table('ijin_pelaksanaan')->where(['ijin_pelaksanaan_id' => $ijin_pelaksanaan_id])->update($data);
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
        $dokumen_proses_ijin_pelaksanaan_id = Crypt::decrypt($request->dokumen_proses_ijin_pelaksanaan_id);
        DB::table('dokumen_proses_ijin_pelaksanaan')->where(['dokumen_proses_ijin_pelaksanaan_id' => $dokumen_proses_ijin_pelaksanaan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('ijin_pelaksanaan')->where(['ijin_pelaksanaan_id' => $id])->update($data);
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
        DB::table('dokumen_proses_ijin_pelaksanaan')->where(['dokumen_proses_ijin_pelaksanaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        $data = DB::table('dokumen')->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','ijin_pelaksanaan')->get();
        $data_dokumen_proses = DB::table('dokumen_proses_ijin_pelaksanaan')
        ->leftJoin('users','users.id','dokumen_proses_ijin_pelaksanaan.created_by')
        ->leftJoin('departement','departement.departement_id','dokumen_proses_ijin_pelaksanaan.departement_id')
        ->whereNull('dokumen_proses_ijin_pelaksanaan.deleted_at')
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
        return view('ijin_pelaksanaan.dokumen', compact('data','id','departement','data_dokumen_proses','commandnya'));
    }

    public function store_doc(Request $request){
        // dd('ok');
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/ijin_pelaksanaan'), $file);
        }
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'link_dokumen' => $request->link_dokumen,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'jenis_dokumen_id' => $request->id,
            'jenis_dokumen' => "ijin_pelaksanaan",
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
