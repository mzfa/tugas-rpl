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
        $data = DB::table('pemesanan')
            ->select('pemesanan.*','penerimaan.id','penerimaan.faktur')
            ->leftJoin('penerimaan','penerimaan.pemesanan_id','pemesanan.pemesanan_id')
            ->whereNull('pemesanan.deleted_at')->get();
        $supplier = DB::table('supplier')->whereNull('deleted_at')->get();
        // dd($data_pemesanan);
        return view('penerimaan.index', compact('data','supplier'));
    }

    public function edit(string $id)
    {
        $data = DB::table('penerimaan')->whereNull('deleted_at')->where('penerimaan_id', $id)->first();
        return view('penerimaan.form', compact('data'));
    }
    public function terima_barang(string $id,$rak)
    {
        // return 'berhasil';
        $data = DB::table('penerimaan_detail')->where('penerimaan_detail_id', $id)->where('rak_id',$rak)->first();
        // dd($data);
        
        if(empty($data->barang_id)){
            $rak = DB::table('rak')
                ->select('gudang.nama as nama_gudang','rak.nama as nama_rak')
                ->join('gudang','gudang.gudang_id','rak.referensi_id')
                ->where('rak_id', $rak)->first();
            return array('error','Ini bukan rak yang tepat. Rak yang benar adalah di rak '.$rak->nama_rak. ' pada gudang '.$rak->nama_gudang);
        }
        if($data->flag_selesai == 1){
            return array('error','Barang sudah check in sebelumnya');
        }
        $bagian_id = Auth::user()->bagian_id;
        $stock_real = DB::table('stock_real')->where([
            'rak_id' => $data->rak_id,
            'barang_id' => $data->barang_id,
            'batch' => $data->batch,
            'expired' => $data->expired,
            'bagian_id' => $bagian_id
        ])
        ->whereNull('deleted_at')
        ->first();
        if(empty($stock_real)){
            $datanya = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'barang_id' => $data->barang_id,
                'batch' => $data->batch,
                'rak_id' => $data->rak_id,
                'expired' => $data->expired,
                'jumlah_barang' => $data->terima,
                'bagian_id' => $bagian_id,
            ];
            DB::table('stock_real')->insert($datanya);
            $jumlahnya =  $data->terima;
        }else{
            $jumlahnya =  $data->terima + $stock_real->jumlah_barang;
            $datanya = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'expired' => $data->expired,
                'jumlah_barang' => $jumlahnya,
                'bagian_id' => 1,
            ];
            $stock_real_id = $stock_real->stock_real_id;
            DB::table('stock_real')->where(['stock_real_id' => $stock_real_id])->update($datanya);
        }
        $kartu_stok = DB::table('kartu_stok')->where([
                'barang_id' => $data->barang_id,
                'bagian_id' => $bagian_id
            ])->whereNull('deleted_at')
            ->orderByDesc('kartu_stok_id')
            ->first();
        $data_kartu_stok = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'barang_id' => $data->barang_id,
            'stok_awal' => $kartu_stok->stok_akhir ?? 0,
            'penambahan' => $jumlahnya,
            'pengurangan' => 0,
            'stok_akhir' => $kartu_stok->stok_akhir ?? 0 + $jumlahnya,
            'bagian_id' => $bagian_id,
            'keterangan' => "Penerimaan Barang",
        ];
        DB::table('kartu_stok')->insert($data_kartu_stok);
        DB::table('penerimaan_detail')->where(['penerimaan_detail_id' => $data->penerimaan_detail_id])->update([
            'flag_selesai' => 1
        ]);
        return array('success',"Barang Berhasil di taruh kedalam rak");
        // return view('penerimaan.form', compact('data'));
    }
    public function scan(string $id)
    {
        // $data = DB::table('pemesanan')->whereNull('deleted_at')->where('pemesanan_id', $id)->first();
        $penerimaan_detail = DB::table('penerimaan_detail')->where('penerimaan_detail_id', $id)->first();
        return view('penerimaan.scan', compact('penerimaan_detail'));
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
        $pemesanan = DB::table('pemesanan')->where('pemesanan_id',$id)->first();
        $rak = DB::table('rak')->whereNull('deleted_at')->get();
        // dd($penerimaan);
        $barang = DB::table('barang')->whereNull('deleted_at')->get();
        return view('penerimaan.detail', compact('pemesanan_detail','barang','id','jumlah','penerimaan_detail_id','pemesanan_detail_id','penerimaan_id','data','penerimaan','rak','pemesanan'));
    }
    public function lihat(string $id)
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
                'penerimaan_detail.rak_id',
                'penerimaan_detail.flag_selesai',
                'rak.nama as nama_rak',
            )
            ->leftJoin('barang','barang.barang_id','pemesanan_detail.barang_id')
            ->leftJoin('penerimaan_detail','pemesanan_detail.pemesanan_detail_id','penerimaan_detail.pemesanan_detail_id')
            ->leftJoin('rak','rak.rak_id','penerimaan_detail.rak_id')
            ->where('pemesanan_detail.pemesanan_id', $id)
            ->get();
        return view('penerimaan.lihat', compact('data'));
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
                'flag_selesai' => $request->flag_selesai,
            ];
            $penerimaan_id = DB::table('penerimaan')->insertGetId($data1);
            DB::table('pemesanan')->where(['pemesanan_id' => $request->pemesanan_id])->update(['flag_selesai' =>$request->flag_selesai]);
        }else{
            $data1 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'tanggal' => $request->tanggal,
                'faktur' => $request->faktur,
                'flag_selesai' => $request->flag_selesai,
            ];
            DB::table('penerimaan')->where(['id' => $request->penerimaan_id])->update($data1);
            // DB::table('pemesanan')->where(['pemesanan_id' => $request->pemesanan_id])->update(['flag_selesai' =>$request->flag_selesai]);
        }
        $stock = [];
        $jumlah_barang_sebelumnya = 0;
        $jumlah_barang_do = 0;
        foreach($request->barang_id as $barang){
            // dump($barang);
            $jumlah_barang_sebelumnya += $request->jumlah_sebelumnya[$barang];
            $jumlah_barang_do += $request->terima[$barang];
            // $penerimaan_detail_sebelumnya = DB::table('penerimaan_detail')->where(['penerimaan_id' => $request->penerimaan_id])->where('barang_id',$barang)->first;
            $data[] = [
                'barang_id' => $barang,
                'pemesanan_detail_id' => $request->pemesanan_detail_id[$barang],
                'terima' => $request->terima[$barang],
                'harga_jual' => $request->harga_jual[$barang],
                'jumlah' => $request->harga_jual[$barang] * $request->terima[$barang],
                'batch' => $request->batch[$barang],
                'rak_id' => $request->rak_id[$barang],
                'expired' => $request->expired[$barang],
                'penerimaan_id' => $penerimaan_id
            ];
        }
        $total = $jumlah_barang_sebelumnya - $jumlah_barang_do;
        if($total == 0){
            DB::table('penerimaan')->where(['id' => $request->penerimaan_id])->update([
                'flag_selesai' => 1
            ]);
            DB::table('pemesanan')->where(['pemesanan_id' => $request->pemesanan_id])->update([
                'flag_selesai' => 1
            ]);
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
