<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenggajianImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }
    public function collection(Collection $collection)
    {
        DB::table('penggajian')->where(['periode_gaji' => $this->data['periode']])->delete();
        foreach($collection as $item){
            if($item[0] != 'NO' && $item[6] != 'nama'){
                $data_import = [
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'nip' => $item[5],
                    'npwp' => $item[1],
                    'ptkp' => $item[2],
                    'pkwt' => $item[3],
                    'no_rek' => $item[4],
                    'nama' => $item[6],
                    'bagian' => $item[7],
                    'pendidikan' => $item[9],
                    'kelas_jabatan' => $item[10],
                    'gaji_pokok' => $item[22],
                    'ip' => $item[24],
                    'tunj_jabatan' => $item[25],
                    'penyesuaian' => $item[26],
                    'total_gaji' => $item[27],
                    'overtime' => $item[28],
                    'double_job' => $item[29],
                    'rapel' => $item[30],
                    'pph_21_dtp' => $item[31],
                    'jumlah_gaji' => $item[32],
                    'bpjs_kesehatan' => $item[33],
                    'bpjs_tk' => $item[34],
                    'pph_21' => $item[35],
                    'kesra' => $item[36],
                    'parkir' => $item[37],
                    'pinjaman' => $item[38],
                    'pemotongan_obat' => $item[39],
                    'lain_lain' => $item[40],
                    'potongan_koperasi' => $item[41],
                    'potongan_absensi' => $item[42],
                    'total_pengurang' => $item[45],
                    'gaji_bersih' => $item[46],
                    'status_kepegawaian_manual' => $item[52],
                    // 'periode_gaji' => $item[30],
                    'periode_gaji' => $this->data['periode'],
                ];
                DB::table('penggajian')->insert($data_import);
            }
            // dump($data_import);
        }
    }
}
