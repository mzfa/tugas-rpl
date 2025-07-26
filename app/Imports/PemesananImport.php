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
            if (empty($item[0])) {
                continue;
            }
            if (empty($item[8])) {
                continue;
            }

            $data_pemesanan = DB::table('pemesanan')->where('purchasing_document', $item[0])->first();

            $supplier_id = substr($item[7],0,8);
            $data[$item[0]] = [
                "supplier_id" => $supplier_id,
                "tanggal" => date("Y-m-d", strtotime($item[6])),
                "purchasing_document" => $item[0],
                "document_date" => date("Y-m-d", strtotime($item[6])),
                "keterangan" => $this->request->keterangan,
                "flag_selesai" => 1,
                "id" => 1,
            ];
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
                "total" => $total
            ];
        }
        // dd($data);
        // Simpan detail setelah selesai loop
        foreach ($data as $key => $value) {
            $data_pemesanan = DB::table('pemesanan')->where('purchasing_document', $key)->first();

            if(empty($data_pemesanan->pemesanan_id)){
                $pemesanan_terakhir = DB::select("SELECT max(kode) as kodeTerbesar FROM pemesanan WHERE deleted_at is null");
                $urutan = (int) substr($pemesanan_terakhir[0]->kodeTerbesar ?? 'PO/0000/000', 11, 3);
                $urutan++;
                $huruf = "PO/" . date('Y/m/');
                $kodepemesanan = $huruf . sprintf("%03s", $urutan);
                $key_id = DB::table("pemesanan")->insertGetId([
                    "supplier_id" => $supplier_id,
                    "tanggal" => date("Y-m-d", strtotime($item[6])),
                    "purchasing_document" => $item[0],
                    "document_date" => date("Y-m-d", strtotime($item[6])),
                    "kode" => $kodepemesanan,
                    "keterangan" => $this->request->keterangan,
                    "flag_selesai" => null,
                ]);
            }else{
                $key_id = $data_pemesanan->pemesanan_id;
                DB::table("pemesanan_detail")
                ->where('pemesanan_id',$data_pemesanan->pemesanan_id)
                    ->delete();
            }
            foreach ($data_detail[$key] as $key1 => $row) {
                // dump($row);
                DB::table("pemesanan_detail")->insert([
                    "barang_id" => $row['barang_id'],
                    "jumlah" => $row['jumlah'],
                    "satuan" => $row['satuan'],
                    "harga_beli" => $row['harga_beli'],
                    "total" => $row['total'],
                    "pemesanan_id" => $key_id
                ]);
            }
        }
        // dd($data_detail);
    }
}
