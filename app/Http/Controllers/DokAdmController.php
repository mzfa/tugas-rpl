<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DokAdmController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('dokumen_administrasi')
        ->select('dokumen_administrasi.*','kategori_dokumen.keterangan_kategori_dokumen')
        ->join('kategori_dokumen','dokumen_administrasi.kategori_dokumen_id','=','kategori_dokumen.kategori_dokumen_id')
        ->whereNull('dokumen_administrasi.deleted_at')->where('dokumen_administrasi.proyek_id',session('proyek_aktif')['id'])->get();
        $kategori_dokumen = DB::table('kategori_dokumen')->whereNull('kategori_dokumen.deleted_at')->get();
        return view('dokumen_administrasi.index', compact('data','kategori_dokumen'));
    }
    public function store(Request $request){
        // dd($request);
        $request->validate([
            'kategori_dokumen_id' => ['required'],
            'no_dokumen' => ['required'],
            'perihal_dokumen' => ['required'],
            'tanggal_dokumen' => ['required'],
            'keterangan' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kategori_dokumen_id' => $request->kategori_dokumen_id,
            'no_dokumen' => $request->no_dokumen,
            'perihal_dokumen' => $request->perihal_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'keterangan' => $request->keterangan,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('dokumen_administrasi')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $kategori_surat = DB::table('kategori_surat')->whereNull('kategori_surat.deleted_at')->get();
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM dokumen_administrasi WHERE dokumen_administrasi_id='$id'")){

            $text = '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Kategori Surat</label>'.
                        '<select name="kategori_surat_id" id="" class="form-select" required>'.
                            '<option value=""></option>';
                            foreach($kategori_surat as $item):
                            $status = ($item->kategori_surat_id==$data[0]->kategori_surat_id) ? 'selected' : '';
                            $text .= '<option value="'. $item->kategori_surat_id .'" '. $status .' >'. $item->keterangan_kategori_surat .'</option>';
                            endforeach;
                            $text .= '</select>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">No Surat</label>'.
                        '<input type="text" class="form-control" id="no_dokumen" name="no_dokumen" value="'.$data[0]->no_dokumen.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Perihal Surat</label>'.
                        '<input type="text" class="form-control" id="perihal_dokumen" name="perihal_dokumen" value="'.$data[0]->perihal_dokumen.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Tanggal Surat</label>'.
                        '<input type="text" class="form-control" id="tanggal_dokumen" name="tanggal_dokumen" value="'.$data[0]->tanggal_dokumen.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Tanggal Terima Surat</label>'.
                        '<input type="text" class="form-control" id="tanggal_terima_surat" name="tanggal_terima_surat" value="'.$data[0]->tanggal_terima_surat.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Keterangan</label>'.
                        '<input type="text" class="form-control" id="keterangan" name="keterangan" value="'.$data[0]->keterangan.'" required>'.
                    '</div>'.
                    '<input type="hidden" class="form-control" id="dokumen_administrasi_id" name="dokumen_administrasi_id" value="'.Crypt::encrypt($data[0]->dokumen_administrasi_id) .'" required>';
        }
        return $text;
        // return view('dokumen_administrasi.edit');
    }

    public function update(Request $request){
        // dd($request);
        $request->validate([
            'kategori_surat_id' => ['required'],
            'no_dokumen' => ['required'],
            'perihal_dokumen' => ['required'],
            'tanggal_dokumen' => ['required'],
            'tanggal_terima_surat' => ['required'],
            'keterangan' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kategori_surat_id' => $request->kategori_surat_id,
            'no_dokumen' => $request->no_dokumen,
            'perihal_dokumen' => $request->perihal_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'tanggal_terima_surat' => $request->tanggal_terima_surat,
            'keterangan' => $request->keterangan,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $dokumen_administrasi_id = Crypt::decrypt($request->dokumen_administrasi_id);
        $status_dokumen_administrasi = "Aktif";
        DB::table('dokumen_administrasi')->where(['dokumen_administrasi_id' => $dokumen_administrasi_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('dokumen_administrasi')->where(['dokumen_administrasi_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    public function delete_doc($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('dokumen_surat')->where(['dokumen_surat_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function doc($id)
    {
        $data = DB::table('dokumen')->whereNull('dokumen.deleted_at')->where('jenis_dokumen_id',$id)->where('jenis_dokumen','dokumen_administrasi')->get();
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->where('departement_id',$id)->get();
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
        return view('dokumen_administrasi.dokumen', compact('data','id','departement','commandnya'));
    }

    public function store_doc(Request $request){
        // dd($request);
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('dokumen/dokumen_administrasi'), $file);
        }
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'link_dokumen' => $request->link_dokumen,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'jenis_dokumen_id' => $request->id,
            'jenis_dokumen' => 'dokumen_administrasi',
        ];
        DB::table('dokumen')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
