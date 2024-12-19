<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NotulenController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('notulen')->where('notulen.proyek_id',session('proyek_aktif')['id'])->whereNull('deleted_at')->get();
        $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
        return view('notulen.index', compact('data','bidang'));
    }
    public function store(Request $request){
        $request->validate([
            'no_notulen' => ['required'],
            'judul' => ['required', 'string'],
            'tanggal_mulai_rapat' => ['required'],
            'tanggal_selesai_rapat' => ['required'],
            'tempat' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_notulen' => $request->no_notulen,
            'judul' => $request->judul,
            'tanggal_mulai_rapat' => $request->tanggal_mulai_rapat,
            'tanggal_selesai_rapat' => $request->tanggal_selesai_rapat,
            'tempat' => $request->tempat,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('notulen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function dokumen_proses_store(Request $request){
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
        DB::table('dokumen_proses_notulen')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM notulen WHERE notulen_id='$id'")){
            $bidang = DB::table('bidang_pekerjaan')->whereNull('bidang_pekerjaan.deleted_at')->get();
            $text = 
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">No Notulen</label>'.
                    '<input type="text" class="form-control" id="no_notulen" name="no_notulen" value="'.$data[0]->no_notulen.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Judul Rapat</label>'.
                    '<input type="text" class="form-control" id="judul" name="judul" value="'.$data[0]->judul.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tanggal Mulai</label>'.
                    '<input type="text" class="form-control" id="tanggal_mulai_rapat" name="tanggal_mulai_rapat" value="'.$data[0]->tanggal_mulai_rapat.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tanggal Selesai</label>'.
                    '<input type="text" class="form-control" id="tanggal_selesai_rapat" name="tanggal_selesai_rapat" value="'.$data[0]->tanggal_selesai_rapat.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Tempat</label>'.
                    '<input type="text" class="form-control" id="tempat" name="tempat" value="'.$data[0]->tempat.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="notulen_id" name="notulen_id" value="'.Crypt::encrypt($data[0]->notulen_id) .'" required>';
        }
        return $text;
        // return view('notulen.edit');
    }

    public function dokumen_proses_edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM dokumen_proses_notulen WHERE dokumen_proses_id='$id'")){
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
                    '<input type="hidden" class="form-control" id="dokumen_proses_id" name="dokumen_proses_id" value="'.Crypt::encrypt($data[0]->dokumen_proses_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request->perihal_material);
        // $request->validate([
        //     'perihal_material' => ['required'],
        //     'bidang_pekerjaan_id' => ['required'],
        //     'revisi_status' => ['required'],
        //     'status_material' => ['required'],
        // ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'no_notulen' => $request->no_notulen,
            'judul' => $request->judul,
            'tanggal_mulai_rapat' => $request->tanggal_mulai_rapat,
            'tanggal_selesai_rapat' => $request->tanggal_selesai_rapat,
            'tempat' => $request->tempat,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $notulen_id = Crypt::decrypt($request->notulen_id);
        DB::table('notulen')->where(['notulen_id' => $notulen_id])->update($data);
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
        $dokumen_proses_id = Crypt::decrypt($request->dokumen_proses_id);
        DB::table('dokumen_proses_notulen')->where(['dokumen_proses_id' => $dokumen_proses_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('notulen')->where(['notulen_id' => $id])->update($data);
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
        DB::table('dokumen_proses_notulen')->where(['dokumen_proses_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        // $data = DB::table('daftar_hadir')->whereNull('daftar_hadir.deleted_at')->leftJoin('pegawai','pegawai.pegawai_id','daftar_hadir.pegawai_id')->where('daftar_hadir.notulen_id',$id)->get();
        $data = DB::table('dokumen')->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','notulen')->get();
        $agenda = DB::table('agenda')->where('agenda.notulen_id',$id)->get();
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
        return view('notulen.dokumen', compact('data','id','agenda','commandnya'));
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
            'jenis_dokumen' => "notulen",
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
