<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GambarKerjaController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('gambar_kerja')->leftJoin('bidang_pekerjaan','gambar_kerja.bidang_pekerjaan_id','bidang_pekerjaan.bidang_pekerjaan_id')->whereNull('gambar_kerja.deleted_at')->where('gambar_kerja.proyek_id',session('proyek_aktif')['id'])->get();
        $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
        return view('gambar_kerja.index', compact('data','bidang'));
    }
    public function store(Request $request){
        // dd($request);
        $request->validate([
            'no_gambar_kerja' => ['required'],
            'perihal_gambar_kerja' => ['required', 'string'],
            'bidang_pekerjaan_id' => ['required'],
            'revisi_status' => ['required'],
            'status_gambar_kerja' => ['required'],
            'tgl_gambar_kerja' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_gambar_kerja' => $request->no_gambar_kerja,
            'perihal_gambar_kerja' => $request->perihal_gambar_kerja,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_gambar_kerja' => $request->status_gambar_kerja,
            'tgl_gambar_kerja' => $request->tgl_gambar_kerja,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('gambar_kerja')->insert($data);
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
        DB::table('dokumen_proses_gambar_kerja')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function uraian_gambar_kerja_store(Request $request){
        // dd($request);
        $request->validate([
            'no_uraian_gambar_kerja' => ['required'],
            'judul_gambar_kerja' => ['required'],
            'revisi_status' => ['required'],
            'status_uraian_gambar_kerja' => ['required'],
            'keterangan' => ['required'],
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_uraian_gambar_kerja' => $request->no_uraian_gambar_kerja,
            'judul_gambar_kerja' => $request->judul_gambar_kerja,
            'revisi_status' => $request->revisi_status,
            'status_uraian_gambar_kerja' => $request->status_uraian_gambar_kerja,
            'keterangan' => $request->keterangan,
        ];
        DB::table('uraian_gambar_kerja')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM gambar_kerja WHERE gambar_kerja_id='$id'")){
            $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">No gambar_kerja Approval</label>'.
                    '<input type="text" class="form-control" id="no_gambar_kerja" name="no_gambar_kerja" value="'.$data[0]->no_gambar_kerja.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Perihal gambar_kerja</label>'.
                    '<input type="text" class="form-control" id="perihal_gambar_kerja" name="perihal_gambar_kerja" value="'.$data[0]->perihal_gambar_kerja.'" required>'.
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
                    '<label for="staticEmail" class="form-label">Status gambar_kerja</label>'.
                    '<select required class="form-control" name="status_gambar_kerja" id="status_gambar_kerja">'.
                        '<option value="">Pilih Status gambar_kerja</option>';
                        $revisi1 = ($data[0]->status_gambar_kerja == "Open") ? "selected" : "";
                        $revisi2 = ($data[0]->status_gambar_kerja == "Close") ? "selected" : "";
                        $text .= '<option '.$revisi1.' value="Open">Open</option>'.
                        '<option '.$revisi2.' value="Close">Close</option>'.
                    '</select>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tanggal Dok Meterial</label>'.
                    '<input type="date" class="form-control" id="tgl_gambar_kerja" name="tgl_gambar_kerja" value="'.$data[0]->tgl_gambar_kerja.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="gambar_kerja_id" name="gambar_kerja_id" value="'.Crypt::encrypt($data[0]->gambar_kerja_id) .'" required>';
        }
        return $text;
        // return view('gambar_kerja.edit');
    }

    public function dokumen_proses_edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM dokumen_proses_gambar_kerja WHERE dokumen_proses_gambar_kerja_id='$id'")){
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
                    '<input type="hidden" class="form-control" id="dokumen_proses_gambar_kerja_id" name="dokumen_proses_gambar_kerja_id" value="'.Crypt::encrypt($data[0]->dokumen_proses_gambar_kerja_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }
    public function uraian_gambar_kerja_edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM uraian_gambar_kerja WHERE uraian_gambar_kerja_id='$id'")){
            $Diperiksa = ($data[0]->status_uraian_gambar_kerja == "Diperiksa") ? "selected" : "";
            $Disetujui = ($data[0]->status_uraian_gambar_kerja == "Disetujui") ? "selected" : "";
            $status1 = ($data[0]->revisi_status == "R-0") ? "selected" : "";
            $status2 = ($data[0]->revisi_status == "R-1") ? "selected" : "";
            $text = 
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">No Uraian Gambar Kerja</label>'.
                        '<input type="text" class="form-control" id="no_uraian_gambar_kerja" value="'.$data[0]->no_uraian_gambar_kerja.'" name="no_uraian_gambar_kerja" required>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Judul Gambar Kerja</label>'.
                        '<input type="text" class="form-control" id="judul_gambar_kerja" value="'.$data[0]->judul_gambar_kerja.'" name="judul_gambar_kerja" required>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Revisi Status</label>'.
                        '<select class="form-control" name="revisi_status" id="revisi_status">'.
                            '<option value="">Pilih Revisi Status</option>'.
                            '<option value="R-0" '.$status1.'>R-0</option>'.
                            '<option value="R-1" '.$status2.'>R-1</option>'.
                        '</select>'.
                    '</div>'.
                    '<div class="col-6 mb-3">'.
                        '<label for="staticEmail" class="form-label">Status Uraian Gambar Kerja</label>'.
                        '<select class="form-control" name="status_uraian_gambar_kerja" id="status_uraian_gambar_kerja">'.
                            '<option value="">Pilih Revisi Status</option>'.
                            '<option value="Diperiksa" '.$Diperiksa.'>Diperiksa</option>'.
                            '<option value="Disetujui" '.$Disetujui.'>Disetujui</option>'.
                        '</select>'.
                    '</div>'.
                    '<div class="col-12 mb-3">'.
                        '<label for="staticEmail" class="form-label">Keterangan</label>'.
                        '<textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control">'.$data[0]->keterangan.'</textarea>'.
                    '</div>'.
                    '<input type="hidden" class="form-control" id="uraian_gambar_kerja_id" name="uraian_gambar_kerja_id" value="'.Crypt::encrypt($data[0]->uraian_gambar_kerja_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request->perihal_gambar_kerja);
        // $request->validate([
        //     'perihal_gambar_kerja' => ['required'],
        //     'bidang_pekerjaan_id' => ['required'],
        //     'revisi_status' => ['required'],
        //     'status_gambar_kerja' => ['required'],
        // ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'no_gambar_kerja' => $request->no_gambar_kerja,
            'perihal_gambar_kerja' => $request->perihal_gambar_kerja,
            'bidang_pekerjaan_id' => $request->bidang_pekerjaan_id,
            'revisi_status' => $request->revisi_status,
            'status_gambar_kerja' => $request->status_gambar_kerja,
            'tgl_gambar_kerja' => $request->tgl_gambar_kerja,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $gambar_kerja_id = Crypt::decrypt($request->gambar_kerja_id);
        DB::table('gambar_kerja')->where(['gambar_kerja_id' => $gambar_kerja_id])->update($data);
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
        $dokumen_proses_gambar_kerja_id = Crypt::decrypt($request->dokumen_proses_gambar_kerja_id);
        DB::table('dokumen_proses_gambar_kerja')->where(['dokumen_proses_gambar_kerja_id' => $dokumen_proses_gambar_kerja_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function uraian_gambar_kerja_update(Request $request){
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_uraian_gambar_kerja' => $request->no_uraian_gambar_kerja,
            'judul_gambar_kerja' => $request->judul_gambar_kerja,
            'revisi_status' => $request->revisi_status,
            'status_uraian_gambar_kerja' => $request->status_uraian_gambar_kerja,
            'keterangan' => $request->keterangan,
        ];
        $uraian_gambar_kerja_id = Crypt::decrypt($request->uraian_gambar_kerja_id);
        DB::table('uraian_gambar_kerja')->where(['uraian_gambar_kerja_id' => $uraian_gambar_kerja_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('gambar_kerja')->where(['gambar_kerja_id' => $id])->update($data);
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
        DB::table('dokumen_proses_gambar_kerja')->where(['dokumen_proses_gambar_kerja_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        $uraian_gambar_kerja = DB::table('uraian_gambar_kerja')->whereNull('uraian_gambar_kerja.deleted_at')->get();
        $data = DB::table('dokumen')
            ->select('dokumen.*','users.name as user_command')
            ->leftJoin('users','users.id','dokumen.command_id')
            ->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','gambar_kerja')->get();
        $data_dokumen_proses = DB::table('dokumen_proses_gambar_kerja')
        ->leftJoin('users','users.id','dokumen_proses_gambar_kerja.created_by')
        ->leftJoin('departement','departement.departement_id','dokumen_proses_gambar_kerja.departement_id')
        ->whereNull('dokumen_proses_gambar_kerja.deleted_at')
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
        return view('gambar_kerja.dokumen', compact('data','id','departement','data_dokumen_proses','uraian_gambar_kerja','commandnya'));
    }

    public function store_doc(Request $request){
        // dd('ok');
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/gambar_kerja'), $file);
        }
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'link_dokumen' => $request->link_dokumen,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'jenis_dokumen_id' => $request->id,
            'jenis_dokumen' => "gambar_kerja",
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
