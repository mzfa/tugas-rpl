<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PenerimaanController extends Controller
{
    public function index()
    {
        $data = DB::table('pemesanan')->whereNull('deleted_at')->get();
        $supplier = DB::table('supplier')->whereNull('deleted_at')->get();
        // dd($data_pemesanan);
        return view('penerimaan.index', compact('data','supplier'));
    }

    public function edit(string $id)
    {
        $data = DB::table('penerimaan')->whereNull('deleted_at')->where('penerimaan_id', $id)->first();
        return view('penerimaan.form', compact('data'));
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
                'penerimaan_detail.batch'
            )
            ->leftJoin('barang','barang.barang_id','pemesanan_detail.barang_id')
            ->leftJoin('penerimaan_detail','pemesanan_detail.pemesanan_detail_id','penerimaan_detail.pemesanan_detail_id')
            ->where('pemesanan_detail.pemesanan_id', $id)
            ->get();
            // dd($data);
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
        // dd($penerimaan);
        $barang = DB::table('barang')->whereNull('deleted_at')->get();
        return view('penerimaan.detail', compact('pemesanan_detail','barang','id','jumlah','penerimaan_detail_id','pemesanan_detail_id','penerimaan_id','data','penerimaan'));
    }

    public function update_detail(Request $request)
    {
        // dd($request);
        $data = [];
        $penerimaan_id = $request->penerimaan_id;
        if(empty($request->penerimaan_id)){
            $penerimaan_terakhir = DB::select("SELECT max(kode) as kodeTerbesar FROM penerimaan WHERE deleted_at is null");
            $urutan = (int) substr($penerimaan_terakhir[0]->kodeTerbesar, 11, 3);
            $urutan++;
            $huruf = "DO/".date('Y/m/');
            $kodepenerimaan = $huruf . sprintf("%03s", $urutan);
            $data1 = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'tanggal' => $request->tanggal,
                'kode' => $kodepenerimaan,
                'faktur' => $request->faktur,
                'pemesanan_id' => $request->pemesanan_id,
            ];
            $penerimaan_id = DB::table('penerimaan')->insertGetId($data1);
        }else{
            $data1 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'tanggal' => $request->tanggal,
                'faktur' => $request->faktur,
            ];
            DB::table('penerimaan')->where(['id' => $request->penerimaan_id])->update($data1);
        }
        foreach($request->barang_id as $barang){
            // dump($barang);
            $data[] = [
                'barang_id' => $barang,
                'pemesanan_detail_id' => $request->pemesanan_detail_id[$barang],
                'terima' => $request->terima[$barang],
                'harga_jual' => $request->harga_jual[$barang],
                'jumlah' => $request->harga_jual[$barang] * $request->terima[$barang],
                'batch' => $request->batch[$barang],
                'expired' => $request->expired[$barang],
                'penerimaan_id' => $penerimaan_id
            ];
        }
        // dd($data,$request);
        DB::table('penerimaan_detail')->where(['penerimaan_id' => $request->penerimaan_id])->delete();
        DB::table('penerimaan_detail')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('penerimaan')->whereNull('deleted_at')->where(['penerimaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}