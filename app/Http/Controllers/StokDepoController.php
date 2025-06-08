<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StokDepoController extends Controller
{
    public function index()
    {
        $bagian = Auth::user()->bagian_id;
        $data = DB::table('stock_real')
            ->select('stock_real.*','barang.nama as nama_barang')
            ->join('barang','barang.barang_id','=','stock_real.barang_id')
            ->where('bagian_id',$bagian)
            ->whereNull('stock_real.deleted_at')
            ->get();
        // dd($data,$bagian);
        return view('stok_depo.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'referensi_id' => $request->referensi_id,
        ];
        DB::table('stok_depo')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $gudang = DB::table('gudang')->whereNull('deleted_at')->get();
        $data = DB::table('stok_depo')->whereNull('deleted_at')->where('stok_depo_id', $id)->first();
        return view('stok_depo.form', compact('data','gudang'));
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
            'kapasitas' => $request->kapasitas,
            'referensi_id' => $request->referensi_id,
        ];
        // dd($request);
        DB::table('stok_depo')->where(['stok_depo_id' => $request->stok_depo_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('stok_depo')->whereNull('deleted_at')->where(['stok_depo_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
