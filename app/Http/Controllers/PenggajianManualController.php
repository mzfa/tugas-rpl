<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenggajianImport;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class PenggajianManualController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $penggajian_manual = DB::table('penggajian')->whereNull('penggajian.deleted_at')->get();
        return view('penggajian.penggajian_manual.index', compact('penggajian_manual'));
    }
    public function import(Request $request){
        // dd(str_replace("-",'', $request->periode));
        $data = [
            'periode' => str_replace("-",'', $request->periode),
        ];
        Excel::import(new PenggajianImport($data), $request->file('file')->store('temp'));
        return back();
    }

    public function store(Request $request){
        $request->validate([
            'jenis_pendidikan_id' => ['required'],
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'jenis_pendidikan_id' => $request->jenis_pendidikan_id,
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        DB::table('pendidikan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM pendidikan WHERE pendidikan_id='$id'")){
            $jurusan = DB::table('pendidikan')->distinct()->get(['jurusan']);

            $text = '<div class="mb-3 row">'.
                '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Instansi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="'.$data[0]->nama_instansi.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Jurusan/Fakultas</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" list="datalistjurusan" name="jurusan" class="form-control" id="address4" value="'.$data[0]->jurusan.'" placeholder="Select Jurusan">'.
                            '<datalist id="datalistjurusan">';
                                foreach($jurusan as $item){
                                    $text .= '<option value="'.$item->jurusan.'">';
                                }
                            $text .='</datalist>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Mulai</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_mulai" name="tahun_mulai" value="'.$data[0]->tahun_mulai.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Lulus</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="'.$data[0]->tahun_lulus.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="pendidikan_id" name="pendidikan_id" value="'.Crypt::encrypt($data[0]->pendidikan_id) .'" required>';
        }
        return $text;
        // return view('pendidikan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        $pendidikan_id = Crypt::decrypt($request->pendidikan_id);
        $status_pendidikan = "Aktif";
        DB::table('pendidikan')->where(['pendidikan_id' => $pendidikan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pendidikan')->where(['pendidikan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
        return view('penggajian.penggajian_manual.detail', compact('data','id'));
    }
    // public function createPDF(){
    //     // retreive all records from db
    //     // $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
    //     // share data to view
    //     $data = [];
    //     view()->share('employee',$data);
    //     $pdf = PDF::loadView('tesprint', $data);
    //     // download PDF file with download method
    //     return $pdf->download('pdf_file.pdf');
    //   }
    
}
