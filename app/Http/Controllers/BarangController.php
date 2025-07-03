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
        $barang_terakhir = DB::select("SELECT max(kode_barang) as kodeTerbesar FROM barang WHERE deleted_at is null");

        $urutan = (int) substr($barang_terakhir[0]->kodeTerbesar, 3, 5);
        $urutan++;
        $huruf = "BR-";
        $kodeBarang = $huruf . sprintf("%05s", $urutan);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'kode_barang' => $kodeBarang,
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
}
