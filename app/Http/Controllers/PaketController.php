<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PaketController extends Controller
{
    public function index()
    {
        $data = DB::table('paket')->whereNull('deleted_at')->get();
        // dd($data_paket);
        return view('paket.index', compact('data'));
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
        ];
        DB::table('paket')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $data = DB::table('paket')->whereNull('deleted_at')->where('paket_id', $id)->first();
        return view('paket.form', compact('data'));
    }
    public function detail(string $id)
    {
        $data = DB::table('paket_detail')->where('paket_id', $id)->get();
        $paket_detail = [];
        foreach($data as $item){
            array_push($paket_detail,$item->barang_id);
        }
        // dd($paket_detail);
        $barang = DB::table('barang')->whereNull('deleted_at')->get();
        return view('paket.detail', compact('paket_detail','barang','id'));
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
        DB::table('paket')->where(['paket_id' => $request->paket_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function update_detail(Request $request)
    {
        $data = [];
        foreach($request->barang_id as $barang){
            $data[] = [
                'barang_id' => $barang,
                'paket_id' => $request->paket_id
            ];
        }
        // dd($data);
        DB::table('paket_detail')->where(['paket_id' => $request->paket_id])->delete();
        DB::table('paket_detail')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('paket')->whereNull('deleted_at')->where(['paket_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
