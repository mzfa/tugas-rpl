<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RakController extends Controller
{
    public function index()
    {
        $gudang = DB::table('gudang')->whereNull('deleted_at')->get();
        $barang = DB::table('barang')->whereNull('deleted_at')->get();
        $data = DB::table('rak')
            ->select('gudang.nama as nama_gudang','rak.*')
            ->leftJoin('gudang','rak.referensi_id','gudang.gudang_id')
            ->whereNull('rak.deleted_at')
            ->get();
        // $data_rak = [];
        // foreach($data as $key => $item){
        //     array_push($data_rak,[
        //         'rak_id' => $item->rak_id,
        //         'nama' => $item->nama,
        //         'sub_rak' => [],
        //     ]);
        //     $data1 = DB::table('rak')->whereNull('deleted_at')->where('referensi_id', $item->rak_id)->get();
        //     foreach($data1 as $key1 => $item1){
        //         array_push($data_rak[$key]['sub_rak'],[
        //             'rak_id' => $item1->rak_id,
        //             'nama' => $item1->nama,
        //             'sub_rak' => [],
        //         ]);
        //         $data2 = DB::table('rak')->whereNull('deleted_at')->where('referensi_id', $item1->rak_id)->get();
        //         foreach($data2 as $key2 => $item2){
        //             array_push($data_rak[$key]['sub_rak'][$key1]['sub_rak'],[
        //                 'rak_id' => $item2->rak_id,
        //                 'nama' => $item2->nama,
        //                 'sub_rak' => [],
        //             ]);
        //             $data3 = DB::table('rak')->whereNull('deleted_at')->where('referensi_id', $item2->rak_id)->get();
        //             foreach($data3 as $key3 => $item3){
        //                 array_push($data_rak[$key]['sub_rak'][$key1]['sub_rak'][$key2]['sub_rak'],[
        //                     'rak_id' => $item3->rak_id,
        //                     'nama' => $item3->nama,
        //                     'sub_rak' => [],
        //                 ]);
        //             }
        //         }
        //     }
        // }
        // dd($data_rak);
        return view('rak.index', compact('data','gudang','barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $barang_id = json_encode($request->barang_id);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'referensi_id' => $request->referensi_id,
            'barang_id' => $barang_id,
        ];
        DB::table('rak')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $gudang = DB::table('gudang')->whereNull('deleted_at')->get();
        $barang = DB::table('barang')->whereNull('deleted_at')->get();
        $data = DB::table('rak')->whereNull('deleted_at')->where('rak_id', $id)->first();
        return view('rak.form', compact('data','gudang','barang'));
    }
    public function barcode(string $id)
    {
        $data = DB::table('rak')->whereNull('deleted_at')->where('rak_id', $id)->first();
        return view('rak.barcode', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $barang_id = json_encode($request->barang_id);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'referensi_id' => $request->referensi_id,
            'barang_id' => $barang_id,
        ];
        DB::table('rak')->where(['rak_id' => $request->rak_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('rak')->whereNull('deleted_at')->where(['rak_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
