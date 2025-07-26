<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LaporanController extends Controller
{
    public function penerimaan()
    {
        $data = DB::table('penerimaan')
            ->select(
                'pemesanan.kode as kode_pemesanan',
                'pemesanan.purchasing_document',
                'pemesanan.tanggal as tanggal_pemesanan',
                'penerimaan.kode as kode_penerimaan',
                'penerimaan.tanggal as tanggal_penerimaan',
                'penerimaan_detail.terima',
                'users.name as petugas',
                'supplier.nama as nama_supplier',
                'barang.nama as nama_barang',
                'barang.barang_id',
                'barang.kode_barang',
                'rak.nama as nama_rak',
                'barang.satuan',
            )
            ->join('pemesanan','pemesanan.pemesanan_id','penerimaan.pemesanan_id')
            ->join('penerimaan_detail','penerimaan_detail.penerimaan_id','penerimaan.id')
            ->join('rak','rak.rak_id','penerimaan_detail.rak_id')
            ->join('barang','barang.barang_id','penerimaan_detail.barang_id')
            ->join('supplier','supplier.supplier_id','pemesanan.supplier_id')
            ->join('users','users.id','penerimaan.created_by')
            ->whereNull('penerimaan.deleted_at')
            ->whereNull('pemesanan.deleted_at')
            ->whereNotNull('penerimaan_detail.flag_selesai')
            ->get();
        $data_penerimaan = [];
        $detail_penerimaan = [];
        foreach($data as $item){
            $data_penerimaan[$item->kode_penerimaan] = [
                "kode_pemesanan" => $item->kode_pemesanan,
                "purchasing_document" => $item->purchasing_document,
                "tanggal_pemesanan" => $item->tanggal_pemesanan,
                "kode_penerimaan" => $item->kode_penerimaan,
                "tanggal_penerimaan" => $item->tanggal_penerimaan,
                "petugas" => $item->petugas,
                "nama_supplier" => $item->nama_supplier,
            ];
            $detail_penerimaan[$item->kode_penerimaan][$item->barang_id] = [  
                "kode_barang" => $item->kode_barang,
                "nama_barang" => $item->nama_barang,
                "nama_rak" => $item->nama_rak,
                "barang_id" => $item->barang_id,
                "terima" => $item->terima,
                "satuan" => $item->satuan,
            ];
        }
        // dd($data_supplier);
        return view('laporan.penerimaan', compact('data_penerimaan','detail_penerimaan'));
    }
    public function permintaan()
    {
        $data = DB::table('permintaan')
            ->select(
                'permintaan.kode as kode_permintaan',
                'permintaan.tanggal as tanggal_permintaan',
                'permintaan.flag_selesai',
                'users.name as petugas',
                'bagian.nama_bagian',
                'barang.nama as nama_barang',
                'barang.barang_id as barang_id',
                'permintaan_detail.jumlah',
            )
            ->join('permintaan_detail','permintaan_detail.permintaan_id','permintaan.permintaan_id')
            ->join('bagian','bagian.bagian_id','permintaan.bagian_id')
            ->join('barang','barang.barang_id','permintaan_detail.barang_id')
            ->leftJoin('users','users.id','permintaan.created_by')
            ->whereNull('permintaan.deleted_at')
            ->get();
        $data_permintaan = [];
        $detail_permintaan = [];
        foreach($data as $item){
            $data_permintaan[$item->kode_permintaan] = [
                "kode_permintaan" => $item->kode_permintaan,
                "tanggal_permintaan" => $item->tanggal_permintaan,
                "flag_selesai" => $item->flag_selesai,
                "petugas" => $item->petugas,
                "nama_bagian" => $item->nama_bagian,
            ];
            $detail_permintaan[$item->kode_permintaan][$item->barang_id] = [  
                "nama_barang" => $item->nama_barang,
                "barang_id" => $item->barang_id,
                "jumlah" => $item->jumlah,
            ];
        }
        return view('laporan.permintaan', compact('data_permintaan','detail_permintaan'));
    }
    public function kartu_stok()
    {
        $data = DB::table('kartu_stok')
            ->select('kartu_stok.*', 'barang.nama as nama_barang','bagian.nama_bagian')
            ->join('barang','barang.barang_id','kartu_stok.barang_id')
            ->join('bagian','bagian.bagian_id','kartu_stok.bagian_id')
            ->whereNull('kartu_stok.deleted_at')
            ->orderByDesc('kartu_stok.barang_id')
            ->orderByDesc('kartu_stok.kartu_stok_id')
            ->get();
        // dd($data);
        return view('laporan.kartu_stok', compact('data'));
    }

}
