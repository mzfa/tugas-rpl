<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProyekController extends Controller
{
    public function index()
    {
        $data = DB::table('proyek')->whereNull('proyek.deleted_at')->get();
        return view('proyek.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_proyek' => ['required', 'string'],
            'alamat_proyek' => ['required', 'string'],
        ]);
        $durasi_kontrak  = date_diff( date_create($request->waktu_pelaksanaan_mulai), date_create($request->waktu_pelaksanaan_berakhir));
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_proyek' => $request->nama_proyek,
            'alamat_proyek' => $request->alamat_proyek,
            'pemberi_tugas' => $request->pemberi_tugas,
            'manajemen_konstruksi' => $request->manajemen_konstruksi,
            'konsultan_perencana' => $request->konsultan_perencana,
            'kontraktor' => $request->kontraktor,
            'sub_kontraktor' => $request->sub_kontraktor,
            'waktu_pelaksanaan_mulai' => $request->waktu_pelaksanaan_mulai,
            'waktu_pelaksanaan_berakhir' => $request->waktu_pelaksanaan_berakhir,
            'uraian_data' => $request->uraian_data,
            'luas_tanah' => $request->luas_tanah,
            'luas_bangunan' => $request->luas_bangunan,
            'jumlah_lantai' => $request->jumlah_lantai,
            'penggunaan' => $request->penggunaan,
            'pro_prof_pic' => $request->pro_prof_pic,
            'durasi_kontrak' => $durasi_kontrak->format('%a'),
            'pro_prof_pic' => $request->pro_prof_pic,
            'lokasi' => $request->lokasi,
        ];
        DB::table('proyek')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM proyek WHERE proyek_id='$id'")){

            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Proyek</label>'.
                    '<input type="text" class="form-control" id="nama_proyek" name="nama_proyek" value="'.$data[0]->nama_proyek.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Alamat Proyek</label>'.
                    '<input type="text" class="form-control" id="alamat_proyek" name="alamat_proyek" value="'.$data[0]->alamat_proyek.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Pemberi Tugas</label>'.
                    '<input type="text" class="form-control" id="pemberi_tugas" name="pemberi_tugas" value="'.$data[0]->pemberi_tugas.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Manajemen Konstruksi</label>'.
                    '<input type="text" class="form-control" id="manajemen_konstruksi" name="manajemen_konstruksi" value="'.$data[0]->manajemen_konstruksi.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Konsultan Perencana</label>'.
                    '<input type="text" class="form-control" id="konsultan_perencana" name="konsultan_perencana" value="'.$data[0]->konsultan_perencana.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Kontraktor</label>'.
                    '<input type="text" class="form-control" id="kontraktor" name="kontraktor" value="'.$data[0]->kontraktor.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Sub Kontraktor</label>'.
                    '<input type="text" class="form-control" id="sub_kontraktor" name="sub_kontraktor" value="'.$data[0]->sub_kontraktor.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Waktu Pelaksanan Mulai</label>'.
                    '<input type="date" class="form-control" id="waktu_pelaksanaan_mulai" name="waktu_pelaksanaan_mulai" value="'.$data[0]->waktu_pelaksanaan_mulai.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Waktu Pelaksanan Berakhir</label>'.
                    '<input type="date" class="form-control" id="waktu_pelaksanaan_berakhir" name="waktu_pelaksanaan_berakhir" value="'.$data[0]->waktu_pelaksanaan_berakhir.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Luas Tanah</label>'.
                    '<input type="text" class="form-control" id="luas_tanah" name="luas_tanah" value="'.$data[0]->luas_tanah.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Luas Bangunan</label>'.
                    '<input type="text" class="form-control" id="luas_bangunan" name="luas_bangunan" value="'.$data[0]->luas_bangunan.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Jumlah Lantai</label>'.
                    '<input type="text" class="form-control" id="jumlah_lantai" name="jumlah_lantai" value="'.$data[0]->jumlah_lantai.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Penggunaan</label>'.
                    '<input type="text" class="form-control" id="penggunaan" name="penggunaan" value="'.$data[0]->penggunaan.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Uraian Data</label>'.
                    '<textarea class="form-control"  name="uraian_data" id="" cols="30" rows="10">'.$data[0]->uraian_data.'</textarea>'.
                '</div>'.
                '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Link Lokasi</label>'.
                    '<textarea name="lokasi" id="lokasi" cols="30" rows="10" class="form-control">'.$data[0]->lokasi.'</textarea>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="proyek_id" name="proyek_id" value="'.Crypt::encrypt($data[0]->proyek_id) .'" required>';
        }
        return $text;
        // return view('proyek.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_proyek' => ['required', 'string'],
            'alamat_proyek' => ['required', 'string'],
        ]);
        $durasi_kontrak  = date_diff( date_create($request->waktu_pelaksanaan_mulai), date_create($request->waktu_pelaksanaan_berakhir));
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_proyek' => $request->nama_proyek,
            'alamat_proyek' => $request->alamat_proyek,
            'pemberi_tugas' => $request->pemberi_tugas,
            'manajemen_konstruksi' => $request->manajemen_konstruksi,
            'konsultan_perencana' => $request->konsultan_perencana,
            'kontraktor' => $request->kontraktor,
            'sub_kontraktor' => $request->sub_kontraktor,
            'waktu_pelaksanaan_mulai' => $request->waktu_pelaksanaan_mulai,
            'waktu_pelaksanaan_berakhir' => $request->waktu_pelaksanaan_berakhir,
            'luas_tanah' => $request->luas_tanah,
            'luas_bangunan' => $request->luas_bangunan,
            'jumlah_lantai' => $request->jumlah_lantai,
            'penggunaan' => $request->penggunaan,
            'uraian_data' => $request->uraian_data,
            'durasi_kontrak' => $durasi_kontrak->format('%a'),
            'lokasi' => $request->lokasi,
        ];
        $proyek_id = Crypt::decrypt($request->proyek_id);
        $status_proyek = "Aktif";
        DB::table('proyek')->where(['proyek_id' => $proyek_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function detail($id){
        $id = Crypt::decrypt($id);
        $data = DB::table('proyek')->where(['proyek_id' => $id])->first();
        return view('proyek.detail', compact('data'));
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('proyek')->where(['proyek_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
