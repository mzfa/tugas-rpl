<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    public function index()
    {
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
        // dd($menu);
        return view('menu.index', compact('menu'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_menu' => ['required', 'string'],
        ]);
        $parent_id = 0;
        if(isset($request->parent_id)){
            $parent_id = $request->parent_id;
        }
        $data = [
            'nama_menu' => $request->nama_menu,
            'icon_menu' => $request->icon_menu,
            'url_menu' => $request->url_menu,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'parent_id' => $parent_id,
        ];

        DB::table('menu')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::table('menu')->where(['menu_id' => $id])->first()){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama menu</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_menu" name="nama_menu" value="'.$data->nama_menu.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="menu_id" name="menu_id" value="'.Crypt::encrypt($data->menu_id) .'" required>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Icon</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="icon_menu" name="icon_menu" value="'.$data->icon_menu.'">'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Url</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="url_menu" name="url_menu" value="'.$data->url_menu.'">'.
                    '</div>'.
                '</div>';
        }
        return $text;
        // return view('admin.menu.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_menu' => ['required', 'string'],
        ]);
        // dd($request);
        $data = [
            'nama_menu' => $request->nama_menu,
            'icon_menu' => $request->icon_menu,
            'url_menu' => $request->url_menu,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ];
        $menu_id = Crypt::decrypt($request->menu_id);
        DB::table('menu')->where(['menu_id' => $menu_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete($id){
        $id = Crypt::decrypt($id);
        // if($data = DB::select("SELECT * FROM tbl_menu WHERE menu_id='$id'")){
        //     DB::select("DELETE FROM tbl_menu WHERE menu_id='$id'");
        // }
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('menu')->where(['menu_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
