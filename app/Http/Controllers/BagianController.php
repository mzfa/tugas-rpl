<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BagianController extends Controller
{
    public function index()
    {
        $bagian = DB::table('bagian')->whereNull('deleted_at')->get();
        $data = DB::table('bagian')->whereNull('deleted_at')->whereNull('referensi_id')->get();
        $data_bagian = [];
        foreach($data as $key => $item){
            array_push($data_bagian,[
                'bagian_id' => $item->bagian_id,
                'nama_bagian' => $item->nama_bagian,
                'sub_bagian' => [],
            ]);
            $data1 = DB::table('bagian')->whereNull('deleted_at')->where('referensi_id', $item->bagian_id)->get();
            foreach($data1 as $key1 => $item1){
                array_push($data_bagian[$key]['sub_bagian'],[
                    'bagian_id' => $item1->bagian_id,
                    'nama_bagian' => $item1->nama_bagian,
                    'sub_bagian' => [],
                ]);
                $data2 = DB::table('bagian')->whereNull('deleted_at')->where('referensi_id', $item1->bagian_id)->get();
                foreach($data2 as $key2 => $item2){
                    array_push($data_bagian[$key]['sub_bagian'][$key1]['sub_bagian'],[
                        'bagian_id' => $item2->bagian_id,
                        'nama_bagian' => $item2->nama_bagian,
                        'sub_bagian' => [],
                    ]);
                    $data3 = DB::table('bagian')->whereNull('deleted_at')->where('referensi_id', $item2->bagian_id)->get();
                    foreach($data3 as $key3 => $item3){
                        array_push($data_bagian[$key]['sub_bagian'][$key1]['sub_bagian'][$key2]['sub_bagian'],[
                            'bagian_id' => $item3->bagian_id,
                            'nama_bagian' => $item3->nama_bagian,
                            'sub_bagian' => [],
                        ]);
                    }
                }
            }
        }
        // dd($data_bagian);
        return view('bagian.index', compact('data_bagian','bagian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bagian' => 'required|min:3|max:255',
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_bagian' => $request->nama_bagian,
            'referensi_id' => $request->referensi_id,
        ];
        DB::table('bagian')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $bagian = DB::table('bagian')->whereNull('deleted_at')->get();
        $data = DB::table('bagian')->whereNull('deleted_at')->where('bagian_id', $id)->first();
        return view('bagian.form', compact('data','bagian'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_bagian' => 'required|min:3|max:255',
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_bagian' => $request->nama_bagian,
            'referensi_id' => $request->referensi_id,
        ];
        // dd($request);
        DB::table('bagian')->where(['bagian_id' => $request->bagian_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function destroy(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('bagian')->whereNull('deleted_at')->where(['bagian_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    public function active(string $id)
    {
        $data = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        DB::table('bagian')->where(['bagian_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Aktifkan kembali!']);
    }
}
