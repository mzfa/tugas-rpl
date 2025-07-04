<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PermintaanController extends Controller
{
    public function index()
    {
        $bagian = Auth::user()->bagian_id;
        if($bagian != 0){
            $data = DB::table('permintaan')->whereNull('deleted_at')->where('bagian_id',$bagian)->get();
        }else{
            $data = DB::table('permintaan')->whereNull('deleted_at')->get();
        }
        $bagian = DB::table('bagian')->whereNull('deleted_at')->get();
        // dd($data_permintaan);
        return view('permintaan.index', compact('data','bagian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|min:3|max:255',
            'bagian_id' => 'required',
        ]);

        $permintaan_terakhir = DB::select("SELECT max(kode) as kodeTerbesar FROM permintaan WHERE deleted_at is null");

        $urutan = (int) substr($permintaan_terakhir[0]->kodeTerbesar, 11, 3);
        $urutan++;
        $huruf = "TR/".date('Y/m/');
        $kodepermintaan = $huruf . sprintf("%03s", $urutan);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'tanggal' => $request->tanggal,
            'kode' => $kodepermintaan,
            'bagian_id' => $request->bagian_id,
            'keterangan' => $request->keterangan,
        ];
        // dd($data);
        DB::table('permintaan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $data = DB::table('permintaan')->whereNull('deleted_at')->where('permintaan_id', $id)->first();
        return view('permintaan.form', compact('data'));
    }
    public function detail(string $id)
    {
        $data_barang = DB::table('permintaan')
            ->join('stock_real','stock_real.bagian_id','permintaan.bagian_id')
            ->join('bagian','bagian.bagian_id','stock_real.bagian_id')
            ->join('barang','barang.barang_id','stock_real.barang_id')
            ->join('rak','rak.rak_id','stock_real.rak_id')
            ->select(
                'barang.nama as nama_barang',
                'rak.nama as nama_rak',
                'barang.satuan',
                'bagian.nama_bagian',
                'stock_real.batch',
                'stock_real.expired',
                'stock_real.barang_id',
                'stock_real.rak_id',
                'stock_real.jumlah_barang',
            )
            ->where('permintaan_id', $id)
            ->get();
        // dd($data_barang);
        $data = DB::table('permintaan_detail')->where('permintaan_id', $id)->get();
        $permintaan = DB::table('permintaan')->where('permintaan_id', $id)->first();
        $permintaan_detail = [];
        $jumlah = [];
        foreach($data as $item){
            array_push($permintaan_detail,$item->barang_id);
            $jumlah[$item->barang_id] = $item->jumlah;
        }
        return view('permintaan.detail', compact('permintaan_detail','id','data_barang','jumlah','permintaan','data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama' => $request->nama,
        ];
        // dd($request);
        DB::table('permintaan')->where(['permintaan_id' => $request->permintaan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function update_detail(Request $request)
    {
        $data = [];
        $bagian_id = Auth::user()->bagian_id;
        $permintaan_id = $request->permintaan_id;
        $status = $request->status;

        if($status == "terima"){
            foreach($request->barang_id as $barang){
                $stock_real = DB::table('stock_real')->where(['rak_id' => $request->rak_id[$barang],'batch' => $request->batch[$barang],'expired' => $request->expired[$barang],'bagian_id' => $bagian_id])->first();
                if(empty($stock_real)){
                    $datanya = [
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'barang_id' => $barang,
                        'batch' => $request->batch[$barang],
                        'rak_id' => $request->rak_id[$barang],
                        'expired' => $request->expired[$barang],
                        'jumlah' => $request->jumlah[$barang],
                        'permintaan_id' => $permintaan_id,
                    ];
                    // dd($datanya);
                    DB::table('stock_real')->insert($datanya);
                }else{
                    $jumlahnya =  $request->jumlah[$barang] + $stock_real->jumlah_barang;
                    $datanya = [
                        'updated_by' => Auth::user()->id,
                        'updated_at' => now(),
                        'expired' => $request->expired[$barang],
                        'jumlah_barang' => $jumlahnya,
                        'bagian_id' => $bagian_id,
                    ];
                    $stock_real_id = $stock_real->stock_real_id;
                    // dd($datanya);
                    DB::table('stock_real')->where(['stock_real_id' => $stock_real_id])->update($datanya);
                }
            }
            $data2 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'flag_selesai' => 3,
            ];
            DB::table('permintaan')->where(['permintaan_id' => $permintaan_id])->update($data2);
            return Redirect::back()->with(['success' => 'Barang Berhasil Di Terima Semua!']);
        }elseif($status == "proses"){
            $data2 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'flag_selesai' => 2,
            ];
            DB::table('permintaan')->where(['permintaan_id' => $permintaan_id])->update($data2);
            return Redirect::back()->with(['success' => 'Barang Sedang di proses!']);
        }else{
            $datanya = [];
            foreach($request->barang_id as $barang){
                $datanya[] = [
                        'barang_id' => $barang,
                        'batch' => $request->batch[$barang],
                        'rak_id' => $request->rak_id[$barang],
                        'expired' => $request->expired[$barang],
                        'jumlah' => $request->jumlah[$barang],
                        'permintaan_id' => $permintaan_id,
                        'satuan' => $request->satuan[$barang],
                ];
                // dd($datanya);
            }
            DB::table('permintaan_detail')->insert($datanya);
            $data2 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'flag_selesai' => 1,
            ];
            DB::table('permintaan')->where(['permintaan_id' => $permintaan_id])->update($data2);
            return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
        }

    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('permintaan')->whereNull('deleted_at')->where(['permintaan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
