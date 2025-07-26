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
                'pemesanan.tanggal as tanggal_pemesanan',
                'penerimaan.kode as kode_penerimaan',
                'penerimaan.tanggal as tanggal_penerimaan',
                'users.name as petugas',
                'supplier.nama as nama_supplier',
            )
            ->join('pemesanan','pemesanan.pemesanan_id','penerimaan.pemesanan_id')
            ->join('supplier','supplier.supplier_id','pemesanan.supplier_id')
            ->join('users','users.id','penerimaan.created_by')
            ->whereNull('penerimaan.deleted_at')
            ->whereNull('pemesanan.deleted_at')
            ->get();
        // dd($data_supplier);
        return view('laporan.penerimaan', compact('data'));
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
