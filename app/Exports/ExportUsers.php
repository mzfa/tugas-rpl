<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;


class ExportUsers implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();
        $data = DB::table('pegawai')
        ->leftJoin('bagian', 'pegawai.bagian_id', '=', 'bagian.bagian_id')
        ->leftJoin('profesi', 'pegawai.profesi_id', '=', 'profesi.profesi_id')
        ->leftJoin('pegawai_detail', 'pegawai.pegawai_id', '=', 'pegawai_detail.pegawai_id')
        ->leftJoin('struktur', 'pegawai_detail.struktur_id', '=', 'struktur.struktur_id')
        ->select([
            'pegawai.*',
            // 'pegawai.tempat_lahir',
            // 'struktur.nama_struktur',
            'bagian.nama_bagian',
            'profesi.nama_profesi'
        ])
        ->whereNull('pegawai.deleted_at')
        ->get();
        // $datanya[] = [
        //     'nip' => 'nip','Tempat Lahir' => 'Tempat Lahir','Bagian' =>'Bagian','Profesi'=> 'Profesi','Status' => 'Status'
        // ];
        // $datanya = '';
        $item = collect();
        $datanya = $item->push((object)['nip' => 'nip','nama_pegawai' => 'Nama Pegawai','Tempat Lahir' => 'Tempat Lahir','Bagian' =>'Bagian','Profesi'=> 'Profesi','Status' => 'Status']);
        foreach($data as $item){
            $status = "Belum Lengkap";
            if($item->tanggal_lahir !== null && $item->alamat !== null && $item->telp_pribadi !== null){
                $status = "Sudah Lengkap";
            }
            $datanya2 = [
                'nip' => $item->nip,
                'nama_pegawai' => $item->nama_pegawai,
                'tempat_lahir' => $item->tempat_lahir,
                'nama_bagian' => $item->nama_bagian,
                'nama_profesi' => $item->nama_profesi,
                'status' => $status

           ];
            $datanya = $datanya->push((object)($datanya2));
        }
        // dd($datanya,$data);
        return $datanya;
    //    return DB::table('users')->get();
    }
}
