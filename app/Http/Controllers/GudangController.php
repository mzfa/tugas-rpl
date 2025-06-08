<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GudangController extends Controller
{
    public function index()
    {
        $data = DB::table('gudang')->whereNull('deleted_at')->get();
        // dd($data_gudang);
        return view('gudang.index', compact('data'));
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
            // 'kapasitas' => $request->kapasitas,
        ];
        DB::table('gudang')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $gudang = DB::table('gudang')->whereNull('deleted_at')->get();
        $data = DB::table('gudang')->whereNull('deleted_at')->where('gudang_id', $id)->first();
        return view('gudang.form', compact('data','gudang'));
    }
    public function rak(string $id)
    {
        $data = DB::table('gudang')->join('rak','gudang.gudang_id','rak.referensi_id')->whereNull('rak.deleted_at')->where('gudang.gudang_id', $id)->get();
        // dd($data);
        return view('gudang.rak', compact('data'));
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
            // 'kapasitas' => $request->kapasitas,
        ];
        // dd($request);
        DB::table('gudang')->where(['gudang_id' => $request->gudang_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function destroy(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('gudang')->whereNull('deleted_at')->where(['gudang_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    public function active(string $id)
    {
        $data = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        DB::table('gudang')->where(['gudang_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Aktifkan kembali!']);
    }
}
