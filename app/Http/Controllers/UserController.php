<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        // $data = DB::table('users')->leftJoin('hakakses', 'users.hakakses_id', '=', 'hakakses.hakakses_id')
        // ->select([
        //     'users.*',
        //     'hakakses.nama_hakakses',
        // ])->whereNull('users.deleted_at')->get();
        $data = DB::table('users')
        ->leftJoin('user_akses', 'users.id', '=', 'user_akses.user_id')
        ->leftJoin('hakakses', 'user_akses.hakakses_id', '=', 'hakakses.hakakses_id')
        ->select([
            'users.*',
            'user_akses.jenis_akses',
            'hakakses.nama_hakakses',
        ])->whereNull('users.deleted_at')->get();
        $pegawai = DB::table('pegawai')->whereNull('pegawai.deleted_at')->get();
        $bagian = DB::table('bagian')->whereNull('bagian.deleted_at')->get();
        return view('user', compact('data','pegawai','bagian'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ];
        DB::table('users')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function editUser($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak dapat di ubah";
        $pegawai = DB::table('pegawai')->whereNull('pegawai.deleted_at')->get();
        $bagian = DB::table('bagian')->whereNull('bagian.deleted_at')->get();
        if($data = DB::select("SELECT * FROM users WHERE id='$id'")){
            $text = '<div class="mb-3">'.
                    '<label for="staticEmail" class="form-label">Nama Lengkap</label>'.
                    '<input type="text" class="form-control" id="name" name="name" value="'.$data[0]->name.'" required>'.
                '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Username</label>'.
                '<input type="text" class="form-control" id="username" name="username" value="'.$data[0]->username.'" required>'.
            '</div>'.
                '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Password</label>'.
                '<input type="password" class="form-control" id="password" name="password" value="'.$data[0]->password.'" required>'.
            '</div>'.
            '<div class="mb-3">'.
                '<label for="staticEmail" class="form-label">Bagian</label>'.
                '<select class="form-control" name="bagian_id">'. 
                '<option></option>';
                foreach ($bagian as $value) {
                    
                    if($data[0]->bagian_id == $value->bagian_id){
                        $text .= '<option selected value="'.$value->bagian_id.'">'.$value->nama_bagian.'</option>';
                    }else{
                        $text .= '<option value="'.$value->bagian_id.'">'.$value->nama_bagian.'</option>';
                    }
                }
                $text .= '</select>'.
            '</div>'.
            '<input type="hidden" class="form-control" id="id" name="id" value="'.Crypt::encrypt($data[0]->id) .'" required>';
        }
        return $text;
    }

    public function updateUser(Request $request){
        // dd($request);
        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'bagian_id' => $request->bagian_id,
        ];
        $id = Crypt::decrypt($request->id);
        $status_departement = "Aktif";
        DB::table('users')->where(['id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('users')->where(['id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $hakakses = DB::table('hakakses')->get();
        if($data = DB::table('users')->leftJoin('user_akses', 'users.id', '=', 'user_akses.user_id')->where(['users.id' => $id])->first()){
        // dd($data);
        $bagian = DB::table('bagian')->whereNull('bagian.deleted_at')->get();
        $text = '<div class="mb-3 row">'.
                    '<input type="hidden" name="user_id" value="'.Crypt::encrypt($id).'">'.
                    '<input type="hidden" name="user_akses_id" value="'.Crypt::encrypt($data->user_akses_id).'">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Hak Akses</label>'.
                    '<div class="col-sm-12">'.
                    '<select class="form-control" name="hakakses_id">'. 
                    '<option></option>';
                    foreach ($hakakses as $value) {
                        if($data->user_akses_id == $value->hakakses_id){
                            $text .= '<option checked value="'.$value->hakakses_id.'">'.$value->nama_hakakses.'</option>';
                        }else{
                            $text .= '<option value="'.$value->hakakses_id.'">'.$value->nama_hakakses.'</option>';
                        }
                    }
                    $text .= '</select>'.
                    '</div>'.
                    '<div class="col-sm-12">'.
                    '<select class="form-control" name="bagian_id">'. 
                    '<option></option>';
                    foreach ($bagian as $value) {
                        if($data->user_akses_id == $value->bagian_id){
                            $text .= '<option checked value="'.$value->bagian_id.'">'.$value->nama_bagian.'</option>';
                        }else{
                            $text .= '<option value="'.$value->bagian_id.'">'.$value->nama_bagian.'</option>';
                        }
                    }
                    $text .= '</select>'.
                    '</div>'.
                '</div>';
        }
        return $text;
        // return view('admin.hakakses.edit');
    }
    public function update(Request $request){
        $request->validate([
            'user_id' => ['required'],
            'hakakses_id' => ['required'],
            // 'jenis_akses' => ['required', 'string'],
        ]);
        $user_id = Crypt::decrypt($request->user_id);
        $data = [
            'user_id' => $user_id,
            'hakakses_id' => $request->hakakses_id,
            // 'jenis_akses' => $request->jenis_akses,
        ];
        $user_akses_id = Crypt::decrypt($request->user_akses_id);
        if(isset($user_akses_id)){
            // dd($request);
            DB::table('user_akses')->where(['user_akses_id' => $user_akses_id])->update($data);
        }else{
            DB::table('user_akses')->insert($data);
        }
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
}
