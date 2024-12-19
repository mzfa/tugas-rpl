<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HakAksesController extends Controller
{
    public function index()
    {
        $data = DB::table('hakakses')->whereNull('deleted_at')->get();
        return view('hakakses.index', compact('data'));
    }
    public function modul_akses($id)
    {
        $id = Crypt::decrypt($id);
        $data_hakakses = DB::select("SELECT * FROM hakakses WHERE hakakses_id='$id'");
        $menu = [];
        $data = DB::table('menu')->where(['parent_id' => 0])->whereNull('deleted_at')->get();
        // dd($data);
        foreach($data as $key => $item)
        {
            array_push($menu, [
                'menu_id' => $item->menu_id,
                'nama_menu' => $item->nama_menu,
                'url_menu' => $item->url_menu,
                'icon_menu' => $item->icon_menu,
                'parent_id' => $item->parent_id,
                'submenu' => []
            ]);
            $menu_id = $item->menu_id;
            $submenu = DB::table('menu')->where(['parent_id' => $menu_id])->whereNull('deleted_at')->get();
            // dd($submenu);
            foreach($submenu as $sub)
            {
                array_push($menu[$key]["submenu"], [
                    "menu_id" => $sub->menu_id,
                    "nama_menu" => $sub->nama_menu,
                    "url_menu" => $sub->url_menu,
                    "icon_menu" => $sub->icon_menu,
                ]);
                // dd($menu['submenu']);
            }
        }
        return view('hakakses.modul_akses', compact('data_hakakses','menu'));
    }
    public function akses_proyek($id)
    {
        $id = Crypt::decrypt($id);
        $data_hakakses = DB::select("SELECT * FROM hakakses WHERE hakakses_id='$id'");
        $menu = [];
        $data = DB::table('proyek')->whereNull('deleted_at')->get();
        // dd($data_hakakses);
        return view('hakakses.akses_proyek', compact('data_hakakses','data','id'));
    }
    public function modul_akses_store(Request $request){
        $menu_id = '';
        $hakakses_id = $request->hakakses_id;
        foreach($request->menu_id as $item){
            $menu_id .= $item."|";
        }
        // dd($menu_id);
        DB::table('hakakses')->where('hakakses_id', $hakakses_id)->update(['menu_id' => $menu_id]);
        return redirect('hakakses')->with(['success' => 'Data Berhasil Di Simpan!']);
    }
    public function akses_proyek_store(Request $request){
        $proyek_id = '';
        $hakakses_id = $request->hakakses_id;
        foreach($request->proyek_id as $item){
            $proyek_id .= $item.",";
        }
        // dd($request);
        DB::table('hakakses')->where('hakakses_id', $hakakses_id)->update(['proyek_id' => $proyek_id]);
        return redirect('hakakses')->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function store(Request $request){
        $request->validate([
            'nama_hakakses' => ['required', 'string'],
        ]);
        $data = [
            'nama_hakakses' => $request->nama_hakakses,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ];
        DB::table('hakakses')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::table('hakakses')->where(['hakakses_id' => $id])->get()){
            // dd($data);
            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Hak Akses</label>'.
                    '<input type="text" class="form-control" id="nama_hakakses" name="nama_hakakses" value="'.$data[0]->nama_hakakses.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="hakakses_id" name="hakakses_id" value="'.Crypt::encrypt($data[0]->hakakses_id) .'" required>';
        }
        return $text;
        // return view('admin.hakakses.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_hakakses' => ['required', 'string'],
        ]);
        $hakakses_id = Crypt::decrypt($request->hakakses_id);
        $data = [
            'nama_hakakses' => $request->nama_hakakses,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ];
        DB::table('hakakses')->where(['hakakses_id' => $hakakses_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Update!']);
    }

    public function delete($id){
        $id = Crypt::decrypt($id);
        // if($data = DB::select("SELECT * FROM hakakses WHERE hakakses_id='$id'")){
        //     DB::select("DELETE FROM hakakses WHERE hakakses_id='$id'");
        // }
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('hakakses')->where(['hakakses_id' => $id])->update($data);
        
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
