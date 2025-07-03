<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class PemesananImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function collection(Collection $collection)
    {
        $data = [];
        $data_detail = [];
        foreach($collection as $key => $item){
            if ($item[0] == "Purchasing Document") {
                continue;
            }

            $data_pemesanan = DB::table('pemesanan')->where('purchasing_document', $item[0])->first();

            if(empty($data_pemesanan->pemesanan_id)){
                // Generate kode PO
                $pemesanan_terakhir = DB::select("SELECT max(kode) as kodeTerbesar FROM pemesanan WHERE deleted_at is null");
                $urutan = (int) substr($pemesanan_terakhir[0]->kodeTerbesar ?? 'PO/0000/000', 11, 3);
                $urutan++;
                $huruf = "PO/" . date('Y/m/');
                $kodepemesanan = $huruf . sprintf("%03s", $urutan);

                $data[$item[0]] = [
                    "supplier_id" => substr($item[7],0,8),
                    "tanggal" => date("Y-m-d", strtotime($item[6])),
                    "purchasing_document" => $item[0],
                    "document_date" => date("Y-m-d", strtotime($item[6])),
                    "kode" => $kodepemesanan,
                    "keterangan" => $this->request->keterangan,
                    "flag_selesai" => 1,
                ];

                $key_id = DB::table("pemesanan")->insertGetId([
                    "supplier_id" => substr($item[7],0,8),
                    "tanggal" => date("Y-m-d", strtotime($item[6])),
                    "purchasing_document" => $item[0],
                    "document_date" => date("Y-m-d", strtotime($item[6])),
                    "kode" => $kodepemesanan,
                    "keterangan" => $this->request->keterangan,
                    "flag_selesai" => null,
                ]);
                $data_pemesanan = DB::table('pemesanan')->where('purchasing_document', $item[0])->first();
            } else {
                $key_id = $data_pemesanan->pemesanan_id;
            }
            // dd($key_id,$data,$data_pemesanan);
            $data[$item[0]]['id'] = $key_id;
            if(!empty($data_detail[$item[0]][$item[8]]['jumlah'])){
                $jumlah = (int) $data_detail[$item[0]][$item[8]]['jumlah'] + (int) $item[17];
            }else{
                $jumlah = (int) $item[17];
            }
            $total = (int) $item[22] * $jumlah;
            $data_detail[$item[0]][$item[8]] = [
                "barang_id" => $item[8],
                "jumlah" => $jumlah,
                "satuan" => $item[18],
                "harga_beli" => $item[22],
                "total" => $total,
                "pemesanan_id" => $key_id,
            ];
        }
        // Simpan detail setelah selesai loop
        foreach ($data_detail as $items) {
            foreach ($items as $key => $row) {
                $data_pemesanan_detail = DB::table("pemesanan_detail")
                ->where('pemesanan_id',$row['pemesanan_id'])
                    ->delete();
                // dd($data_pemesanan_detail,$row);
                DB::table("pemesanan_detail")->insert($row);
            }
        }
    }
}
