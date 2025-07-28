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
        if($bagian != 0 && $bagian !== 1){
            $data = DB::table('permintaan')
                ->select(
                    'permintaan.permintaan_id',
                    'permintaan.kode',
                    'permintaan.tanggal',
                    'permintaan.keterangan',
                    'permintaan.flag_selesai',
                    'users.bagian_id',
                )
                ->join('users','users.id','permintaan.created_by')
                ->whereNull('permintaan.deleted_at')
                ->where('users.bagian_id',$bagian)
                ->get();
        }else{
            $data = DB::table('permintaan')
                ->select(
                    'permintaan.permintaan_id',
                    'permintaan.kode',
                    'permintaan.tanggal',
                    'permintaan.keterangan',
                    'permintaan.flag_selesai',
                    'users.bagian_id',
                )
                ->join('users','users.id','permintaan.created_by')
                ->whereNull('permintaan.deleted_at')->get();
            // dd($data);
        }
        $bagian = DB::table('bagian')->whereNull('deleted_at')->whereNotIn('bagian_id',[$bagian])->get();
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
        $data_barang = DB::table('stock_real')
            ->join('bagian','bagian.bagian_id','stock_real.bagian_id')
            ->join('barang','barang.barang_id','stock_real.barang_id')
            ->join('rak','rak.rak_id','stock_real.rak_id')
            ->select(
                'barang.nama as nama_barang',
                'rak.nama as nama_rak',
                'barang.satuan',
                'bagian.nama_bagian',
                'stock_real.stock_real_id',
                'stock_real.batch',
                'stock_real.expired',
                'stock_real.barang_id',
                'stock_real.rak_id',
                'stock_real.jumlah_barang',
            )
            ->where('stock_real.bagian_id', 1)
            ->whereNull('stock_real.deleted_at')
            ->get();
        // dd($data_barang);
        $data = DB::table('permintaan_detail')->where('permintaan_id', $id)->get();
        $permintaan = DB::table('permintaan')->where('permintaan_id', $id)->first();
        $permintaan_detail = [];
        $jumlah = [];
        $data_mapping = [];
        foreach ($data_barang as $key => $value) {
            $jumlah_barang = $value->jumlah_barang;
            if (!empty($data_mapping[$value->barang_id]['jumlah_barang'])) {
                $jumlah_barang += $data_mapping[$value->barang_id]['jumlah_barang'];
            }
            $data_mapping[$value->barang_id] = [
                "stock_real_id" => $value->stock_real_id,
                "nama_barang" => $value->nama_barang,
                "nama_rak" => $value->nama_rak,
                "satuan" => $value->satuan,
                "nama_bagian" => $value->nama_bagian,
                "batch" => $value->batch,
                "expired" => $value->expired,
                "barang_id" => $value->barang_id,
                "rak_id" => $value->rak_id,
                "jumlah_barang" => $jumlah_barang,
            ];
        }

        foreach($data as $item){
            array_push($permintaan_detail,$item->barang_id);
            $jumlah[$item->barang_id] = $item->jumlah;
        }
        return view('permintaan.detail', compact('permintaan_detail','id','data_barang','jumlah','permintaan','data','data_mapping'));
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

        $data_permintaan = DB::table('permintaan')->where(['permintaan_id' => $permintaan_id])->first();

        if($status == "terima"){
            foreach($request->barang_id as $key => $barang){
                // dd($barang);
                if(!empty($request->jumlah[$key])){
                    if($request->jumlah[$key] > 0){
                        $stock_real = DB::table('stock_real')
                            ->where(['rak_id' => $request->rak_id[$key],'batch' => $request->batch[$key],'expired' => $request->expired[$key],'bagian_id' => $bagian_id])->first();
                        if(empty($stock_real)){
                            $datanya = [
                                'created_by' => Auth::user()->id,
                                'created_at' => now(),
                                'barang_id' => $barang,
                                'batch' => $request->batch[$key],
                                'rak_id' => $request->rak_id[$key],
                                'bagian_id' => $bagian_id,
                                'expired' => $request->expired[$key],
                                'jumlah_barang' => $request->jumlah[$key],
                                // 'permintaan_id' => $permintaan_id,
                            ];
                            // dd($datanya);
                            DB::table('stock_real')->insert($datanya);
                            $jumlahnya = $request->jumlah[$key];
                        }else{
                            $jumlahnya =  $request->jumlah[$key] + $stock_real->jumlah_barang;
                            $datanya = [
                                'updated_by' => Auth::user()->id,
                                'updated_at' => now(),
                                'expired' => $request->expired[$key],
                                'jumlah_barang' => $jumlahnya,
                                'bagian_id' => $bagian_id,
                            ];
                            $stock_real_id = $stock_real->stock_real_id;
                            // dd($datanya);
                            DB::table('stock_real')->where(['stock_real_id' => $stock_real_id])->update($datanya);
                        }
                        $kartu_stok = DB::table('kartu_stok')->where([
                                'barang_id' => $barang,
                                'bagian_id' => $bagian_id
                            ])->whereNull('deleted_at')
                            ->orderByDesc('kartu_stok_id')
                            ->first();
                        $data_kartu_stok = [
                            'created_by' => Auth::user()->id,
                            'created_at' => now(),
                            'barang_id' => $bagian_id,
                            'stok_awal' => $kartu_stok->stok_akhir ?? 0,
                            'penambahan' => $request->jumlah[$key],
                            'pengurangan' => 0,
                            'stok_akhir' => $kartu_stok->stok_akhir ?? 0 + $request->jumlah[$key],
                            'bagian_id' => $bagian_id,
                            'keterangan' => "Penerimaan Mutasi Barang",
                        ];
                        DB::table('kartu_stok')->insert($data_kartu_stok);
                    }
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
            foreach($request->barang_id as $key => $barang){
                // dd($barang);
                if(!empty($request->jumlah[$key])){
                    if($request->jumlah[$key] > 0){
                        $stock_real = DB::table('stock_real')->where(['rak_id' => $request->rak_id[$barang],'batch' => $request->batch[$barang],'bagian_id' => $bagian_id])->first();
                        if(empty($stock_real)){
                            return Redirect::back()->with(['error' => 'Maaf barang ini tidak tersedia!']);
                        }else{
                            $jumlahnya = $stock_real->jumlah_barang - $request->jumlah[$key];
                            // dd($jumlahnya);
                            $datanya = [
                                'updated_by' => Auth::user()->id,
                                'updated_at' => now(),
                                'jumlah_barang' => $jumlahnya,
                            ];
                            DB::table('stock_real')->where(['stock_real_id' => $stock_real->stock_real_id])->update($datanya);

                            $kartu_stok = DB::table('kartu_stok')->where([
                                    'barang_id' => $barang,
                                    'bagian_id' => $bagian_id
                                ])->whereNull('deleted_at')
                                ->orderByDesc('kartu_stok_id')
                                ->first();
                            $data_kartu_stok = [
                                'created_by' => Auth::user()->id,
                                'created_at' => now(),
                                'barang_id' => $bagian_id,
                                'stok_awal' => $kartu_stok->stok_akhir ?? 0,
                                'penambahan' => 0,
                                'pengurangan' => $request->jumlah[$key],
                                'stok_akhir' => $kartu_stok->stok_akhir ?? 0 + $request->jumlah[$key],
                                'bagian_id' => $bagian_id,
                                'keterangan' => "Penerimaan Mutasi Barang",
                            ];
                            DB::table('kartu_stok')->insert($data_kartu_stok);
                        }
                    }
                }
            }
            // dd($request,$datanya);

            $data2 = [
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
                'flag_selesai' => 2,
            ];
            DB::table('permintaan')->where(['permintaan_id' => $permintaan_id])->update($data2);
            return Redirect::back()->with(['success' => 'Barang Sedang di proses!']);
        }else{
            $datanya = [];
            foreach($request->barang_id as $key => $barang){
                if(!empty($request->jumlah[$key])){
                    if($request->jumlah[$key] > 0){
                        $datanya[] = [
                            'barang_id' => $barang,
                            'batch' => $request->batch[$barang],
                            'rak_id' => $request->rak_id[$barang],
                            'expired' => $request->expired[$barang],
                            'jumlah' => $request->jumlah[$key],
                            'permintaan_id' => $permintaan_id,
                            'satuan' => $request->satuan[$barang] ?? '',
                        ];
                    }
                }
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
