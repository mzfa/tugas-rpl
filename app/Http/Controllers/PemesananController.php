<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\PemesananImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class PemesananController extends Controller
{
    public function index()
    {
        $data = DB::table('pemesanan')->whereNull('deleted_at')->get();
        $supplier = DB::table('supplier')->whereNull('deleted_at')->get();
        // dd($data_pemesanan);
        return view('pemesanan.index', compact('data','supplier'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // dd($request);
        
        $file = $request->file('file');

        // membuat nama file unik
        Excel::import(new PemesananImport($request), $request->file('file'));
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
        // $request->validate([
        //     'file' => 'required',
        // ]);

        // $pemesanan_terakhir = DB::select("SELECT max(kode) as kodeTerbesar FROM pemesanan WHERE deleted_at is null");

        // $urutan = (int) substr($pemesanan_terakhir[0]->kodeTerbesar, 11, 3);
        // $urutan++;
        // $huruf = "PO/".date('Y/m/');
        // $kodepemesanan = $huruf . sprintf("%03s", $urutan);
        // $data = [
        //     'created_by' => Auth::user()->id,
        //     'created_at' => now(),
        //     'tanggal' => $request->tanggal,
        //     'kode' => $kodepemesanan,
        //     'supplier_id' => $request->supplier_id,
        //     'keterangan' => $request->keterangan,
        // ];
        // // dd($data);
        // DB::table('pemesanan')->insert($data);

        // return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $data = DB::table('pemesanan')->whereNull('deleted_at')->where('pemesanan_id', $id)->first();
        return view('pemesanan.form', compact('data'));
    }
    public function detail(string $id)
    {
        $data = DB::table('pemesanan_detail')
            ->select(
                'barang.nama',
                'barang.kode_barang',
                'barang.harga_jual',
                'pemesanan_detail.*',
                'penerimaan_detail.terima',
                'penerimaan_detail.expired',
                'penerimaan_detail.penerimaan_id',
                'penerimaan_detail.penerimaan_detail_id',
                'penerimaan_detail.batch',
                'rak.rak_id',
                'rak.nama as nama_rak',
            )
            ->leftJoin('barang','barang.barang_id','pemesanan_detail.barang_id')
            ->leftJoin('penerimaan_detail','pemesanan_detail.pemesanan_detail_id','penerimaan_detail.pemesanan_detail_id')
            ->leftJoin('rak', function($join) {
                $join->whereRaw("rak.barang_id LIKE CONCAT('%\"', pemesanan_detail.barang_id, '\"%')");
            })
            ->where('pemesanan_detail.pemesanan_id', $id)
            ->get();
        $pemesanan_detail = [];
        $jumlah = [];
        $terima = [];
        $penerimaan_detail_id = [];
        $pemesanan_detail_id = [];
        $penerimaan_id = [];
        $id_penerimaan = '';
        foreach($data as $item){
            array_push($pemesanan_detail,$item->barang_id);
            $jumlah[$item->barang_id] = $item->jumlah;
            $terima[$item->barang_id] = $item->terima;
            $penerimaan_detail_id[$item->barang_id] = $item->penerimaan_detail_id;
            $pemesanan_detail_id[$item->barang_id] = $item->pemesanan_detail_id;
            $penerimaan_id[$item->barang_id] = $item->penerimaan_id;
        }
        $penerimaan = DB::table('penerimaan')->where('pemesanan_id',$id)->first();
        $rak = DB::table('rak')->whereNull('deleted_at')->get();
        return view('pemesanan.detail', compact('pemesanan_detail','id','jumlah','penerimaan_detail_id','pemesanan_detail_id','penerimaan_id','data','penerimaan','rak'));
    }

    public function update(Request $request)
    {
        dd($request);        
        $request->validate([
            'file' => 'required',
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama' => $request->nama,
        ];
        // dd($request);
        DB::table('pemesanan')->where(['pemesanan_id' => $request->pemesanan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function update_detail(Request $request)
    {
        $data = [];
        foreach($request->barang_id as $barang){
            // dump($barang);
            $data[] = [
                'barang_id' => $barang,
                'satuan' => $request->satuan[$barang] ?? '-',
                'harga_beli' => $request->harga_beli[$barang],
                'jumlah' => $request->jumlah[$barang],
                'total' => $request->harga_beli[$barang] * $request->jumlah[$barang],
                'pemesanan_id' => $request->pemesanan_id
            ];
        }
        // dd($data,$request);
        DB::table('pemesanan_detail')->where(['pemesanan_id' => $request->pemesanan_id])->delete();
        DB::table('pemesanan_detail')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pemesanan')->whereNull('deleted_at')->where(['pemesanan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
