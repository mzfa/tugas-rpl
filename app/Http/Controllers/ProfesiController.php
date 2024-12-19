<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfesiController extends Controller
{
    public function index()
    {
        $data = DB::table('profesi')
        ->whereNull('profesi.deleted_at')
        ->get();
        return view('profesi', compact('data'));
    }

    public function sync()
    {
        $list_profesi_phis = DB::connection('PHIS-V2')
            ->table('profesi')
            ->select([
                'profesi_id',
                'input_time',
                'input_user_id',
                'mod_time',
                'mod_user_id',
                'status_batal',
                'nama_profesi'
            ])
            ->orderBy('profesi_id')
            ->get();

        foreach ($list_profesi_phis as $profesi) {
            if ($profesi->status_batal) {
                $deleted_at = $profesi->mod_time ?? now();
                $deleted_by = $profesi->mod_user_id ?? 1;
            } else {
                $deleted_at = null;
                $deleted_by = null;
            }
            $datanya[] = [
                'profesi_id' => $profesi->profesi_id,
                'created_at' => $profesi->input_time,
                'created_by' => $profesi->input_user_id,
                'updated_at' => $profesi->mod_time,
                'updated_by' => $profesi->mod_user_id,
                'deleted_at' => $deleted_at,
                'deleted_by' => $deleted_by,
                'nama_profesi' => $profesi->nama_profesi
            ];
        }

        DB::table('profesi')->truncate();
        DB::table('profesi')->insert($datanya);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Perbarui!']);

        // return redirect()->back()->with('status', ['success', 'Data berhasil disimpan']);
    }
}
