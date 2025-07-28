<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BarangController extends Controller
{
    public function index()
    {
        $data = DB::table('barang')
            // ->where('created_at', '>', date('Y-m-d'))
            ->whereNull('deleted_at')->get();
        // dd($data_barang);
        return view('barang.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $nama_file = '';
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            $request->file('file')->move(public_path('gambar/barang'), $file);
            // $image = asset('gambar/'.$nama_file);
        }
        // die();
        // $barang_terakhir = DB::select("SELECT max(kode_barang) as kodeTerbesar FROM barang WHERE deleted_at is null");

        // $urutan = (int) substr($barang_terakhir[0]->kodeTerbesar, 3, 5);
        // $urutan++;
        // $huruf = "BR-";
        // $kodeBarang = $huruf . sprintf("%05s", $urutan);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            // 'kode_barang' => $kodeBarang,
            'kode_barang' => $request->kode_barang,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'satuan' => $request->satuan,
            'stok_minimal' => $request->stok_minimal,
            'stok_maksimal' => $request->stok_maksimal,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'gambar' => $nama_file,
        ];
        DB::table('barang')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $data = DB::table('barang')->whereNull('deleted_at')->where('barang_id', $id)->first();
        return view('barang.form', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $nama_file = $request->gambar;
        // dd($nama_file);
        if($request->hasFile('file')){
            $file = round(microtime(true) * 1000).'-'.str_replace(' ','-',$request->file('file')->getClientOriginalName());
            $nama_file = $file;
            echo $request->file('file')->move(public_path('gambar/barang'), $file);
            // $image = asset('gambar/'.$nama_file);
        }
        
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'satuan' => $request->satuan,
            'stok_minimal' => $request->stok_minimal,
            'stok_maksimal' => $request->stok_maksimal,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'gambar' => $nama_file
        ];
        // dd($request);
        DB::table('barang')->where(['barang_id' => $request->barang_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('barang')->whereNull('deleted_at')->where(['barang_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function detail(string $id)
    {
        $bagian_id = Auth::user()->bagian_id;
        $data = DB::table('barang')->whereNull('deleted_at')->where('barang_id', $id)->first();
        $rak = DB::table('rak')->whereNull('deleted_at')->get();
        $stok_real = DB::table('stock_real')
            ->leftJoin('rak','rak.rak_id','stock_real.rak_id')
            ->whereNull('stock_real.deleted_at')
            ->where('stock_real.barang_id', $id)
            ->where('stock_real.bagian_id', $bagian_id)
            ->get();
        return view('barang.detail', compact('data','stok_real','rak'));
    }

    public function stok_depo_store(Request $request)
    {
        $request->validate([
            'batch' => 'required',
        ]);
        // dd($request);
        $bagian_id = Auth::user()->bagian_id;
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'barang_id' => $request->barang_id,
            'batch' => $request->batch,
            'jumlah_barang' => $request->jumlah_barang,
            'rak_id' => $request->rak_id,
            'bagian_id' => $bagian_id,
        ];
        DB::table('stock_real')->insert($data);

        $kartu_stok = DB::table('kartu_stok')->where([
                'barang_id' => $request->barang_id,
                'bagian_id' => $bagian_id
            ])->whereNull('deleted_at')
            ->orderByDesc('kartu_stok_id')
            ->first();
        $penambahan = (int) $request->jumlah_barang;
        $stok_akhir = $penambahan + ($kartu_stok->stok_akhir ?? 0);
        $data_kartu_stok = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'barang_id' => $request->barang_id,
            'stok_awal' => $kartu_stok->stok_akhir ?? 0,
            'penambahan' => $penambahan,
            'pengurangan' => 0,
            'stok_akhir' => $stok_akhir,
            'bagian_id' => $bagian_id,
            'keterangan' => "Penyesuaian Stok Barang",
        ];
        DB::table('kartu_stok')->insert($data_kartu_stok);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function stok_depo_edit(string $id)
    {
        $stok_depo = DB::table('stock_real')->whereNull('deleted_at')->where('stock_real_id', $id)->first();
        $rak = DB::table('rak')->whereNull('deleted_at')->get();
        return view('barang.stok_depo_form', compact('stok_depo','rak'));
    }

    public function stok_depo_update(Request $request)
    {
        $request->validate([
            'batch' => 'required',
        ]);
        // dd($request);
        $bagian_id = Auth::user()->bagian_id;
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'batch' => $request->batch,
            'jumlah_barang' => $request->jumlah_barang,
            'rak_id' => $request->rak_id,
        ];
        DB::table('stock_real')->insert($data);

        $jumlah_sebelumnya = $request->jumlah_sebelumnya;

        $kartu_stok = DB::table('kartu_stok')->where([
                'barang_id' => $request->barang_id,
                'bagian_id' => $bagian_id
            ])->whereNull('deleted_at')
            ->orderByDesc('kartu_stok_id')
            ->first();

        $jumlah_barang = (int) $request->jumlah_barang;
        $stok_akhir_penambahan = $jumlah_barang + ($kartu_stok->stok_akhir ?? 0);
        $stok_akhir_pengurangan = ($kartu_stok->stok_akhir ?? 0) - $jumlah_barang;

        if(($jumlah_sebelumnya - $request->jumlah_barang) > 0){
            $data_kartu_stok = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'barang_id' => $request->barang_id,
                'stok_awal' => $kartu_stok->stok_akhir ?? 0,
                'penambahan' => 0,
                'pengurangan' => $jumlah_barang,
                'stok_akhir' => $stok_akhir_pengurangan,
                'bagian_id' => $bagian_id,
                'keterangan' => "Penyesuaian Stok Barang",
            ];
            DB::table('kartu_stok')->insert($data_kartu_stok);
        }elseif(($jumlah_sebelumnya - $request->jumlah_barang) < 0){
            $data_kartu_stok = [
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'barang_id' => $request->barang_id,
                'stok_awal' => $kartu_stok->stok_akhir ?? 0,
                'penambahan' => $jumlah_barang,
                'pengurangan' => 0,
                'stok_akhir' => $stok_akhir_penambahan,
                'bagian_id' => $bagian_id,
                'keterangan' => "Penyesuaian Stok Barang",
            ];
            DB::table('kartu_stok')->insert($data_kartu_stok);
        }else{

        }
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function stok_depo_delete(string $id)
    {
        // dd($id);
        $bagian_id = Auth::user()->bagian_id;
        $stok_depo = DB::table('stock_real')->whereNull('deleted_at')->where('stock_real_id', $id)->first();
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('stock_real')->whereNull('deleted_at')->where(['stock_real_id' => $id])->update($data);

        $kartu_stok = DB::table('kartu_stok')->where([
                'barang_id' => $stok_depo->barang_id,
                'bagian_id' => $bagian_id
            ])->whereNull('deleted_at')
            ->orderByDesc('kartu_stok_id')
            ->first();

        $jumlah_barang = (int) $stok_depo->jumlah_barang;
        $stok_akhir_pengurangan = ($kartu_stok->stok_akhir ?? 0) - $jumlah_barang;

        $data_kartu_stok = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'barang_id' => $stok_depo->barang_id,
            'stok_awal' => $kartu_stok->stok_akhir ?? 0,
            'penambahan' => 0,
            'pengurangan' => $jumlah_barang,
            'stok_akhir' => $stok_akhir_pengurangan,
            'bagian_id' => $bagian_id,
            'keterangan' => "Penyesuaian Stok Barang",
        ];
        DB::table('kartu_stok')->insert($data_kartu_stok);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
