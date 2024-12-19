<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SuratMenyuratController extends Controller
{
    public function index()
    {
        $data = DB::table('dokumen_administrasi')
        ->select('dokumen_administrasi.*','kategori_dokumen.keterangan_kategori_dokumen')
        ->join('kategori_dokumen','dokumen_administrasi.kategori_dokumen_id','=','kategori_dokumen.kategori_dokumen_id')
        ->whereNull('dokumen_administrasi.deleted_at')->get();
        // dd($data);
        $kategori_dokumen = DB::table('kategori_dokumen')->whereNull('kategori_dokumen.deleted_at')->get();
        return view('surat_menyurat.index', compact('data','kategori_dokumen'));
    }
    public function store(Request $request){
        // dd($request);
        $request->validate([
            'kategori_surat_id' => ['required'],
            'no_surat' => ['required'],
            'perihal_surat' => ['required'],
            'tanggal_surat' => ['required'],
            'tanggal_terima_surat' => ['required'],
            'penerbit_id' => ['required'],
            'tujuan_id' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kategori_surat_id' => $request->kategori_surat_id,
            'no_surat' => $request->no_surat,
            'perihal_surat' => $request->perihal_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima_surat' => $request->tanggal_terima_surat,
            'penerbit_id' => $request->penerbit_id,
            'tujuan_id' => $request->tujuan_id,
        ];
        DB::table('surat_menyurat')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $kategori_surat = DB::table('kategori_surat')->whereNull('kategori_surat.deleted_at')->get();
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        if($data = DB::select("SELECT * FROM surat_menyurat WHERE surat_menyurat_id='$id'")){

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
                        '<input type="text" class="form-control" id="no_surat" name="no_surat" value="'.$data[0]->no_surat.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Perihal Surat</label>'.
                        '<input type="text" class="form-control" id="perihal_surat" name="perihal_surat" value="'.$data[0]->perihal_surat.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Tanggal Surat</label>'.
                        '<input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" value="'.$data[0]->tanggal_surat.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Tanggal Terima Surat</label>'.
                        '<input type="text" class="form-control" id="tanggal_terima_surat" name="tanggal_terima_surat" value="'.$data[0]->tanggal_terima_surat.'" required>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Penerbit Surat</label>'.
                        '<select name="penerbit_id" id="" class="form-select" required>'.
                            '<option value=""></option>';
                            foreach($departement as $item):
                            $status = ($item->departement_id==$data[0]->penerbit_id) ? 'selected' : '';
                            $text .= '<option value="'. $item->departement_id .'" '. $status .'>'. $item->nama_departement .'</option>';
                            endforeach;
                            $text .= '</select>'.
                    '</div>'.
                    '<div class="mb-3">'.
                        '<label for="staticEmail" class="form-label">Tujuan Surat</label>'.
                        '<select name="tujuan_id" id="" class="form-select" required>'.
                            '<option value=""></option>';
                            foreach($departement as $item):
                            $status = ($item->departement_id==$data[0]->tujuan_id) ? 'selected' : '';
                            $text .= '<option value="'. $item->departement_id .'" '. $status .'>'. $item->nama_departement .'</option>';
                            endforeach;
                            $text .= '</select>'.
                    '</div>'.
                    '<input type="hidden" class="form-control" id="surat_menyurat_id" name="surat_menyurat_id" value="'.Crypt::encrypt($data[0]->surat_menyurat_id) .'" required>';
        }
        return $text;
        // return view('surat_menyurat.edit');
    }


    public function update(Request $request){
        // dd($request);
        $request->validate([
            'kategori_surat_id' => ['required'],
            'no_surat' => ['required'],
            'perihal_surat' => ['required'],
            'tanggal_surat' => ['required'],
            'tanggal_terima_surat' => ['required'],
            'penerbit_id' => ['required'],
            'tujuan_id' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'kategori_surat_id' => $request->kategori_surat_id,
            'no_surat' => $request->no_surat,
            'perihal_surat' => $request->perihal_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima_surat' => $request->tanggal_terima_surat,
            'penerbit_id' => $request->penerbit_id,
            'tujuan_id' => $request->tujuan_id,
        ];
        $surat_menyurat_id = Crypt::decrypt($request->surat_menyurat_id);
        $status_surat_menyurat = "Aktif";
        DB::table('surat_menyurat')->where(['surat_menyurat_id' => $surat_menyurat_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('surat_menyurat')->where(['surat_menyurat_id' => $id])->update($data);
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
        $data = DB::table('dokumen_surat')->whereNull('dokumen_surat.deleted_at')->where('surat_menyurat_id',$id)->get();
        return view('surat_menyurat.dokumen', compact('data','id'));
    }

    public function store_doc(Request $request){
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
            'surat_menyurat_id' => $request->id,
        ];
        DB::table('dokumen_surat')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    
}
