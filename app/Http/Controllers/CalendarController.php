<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CalendarController extends Controller
{
    public function index()
    {
        if(session('proyek_aktif')['id'] == 0){
            return Redirect::back()->with(['error' => 'Anda belum memilih proyek!']);
        }
        $data = DB::table('departement')->whereNull('departement.deleted_at')->get();
        $event = DB::table('event')->where('event.proyek_id',session('proyek_aktif')['id'])->whereNull('event.deleted_at')->get();
        $eventnya = [];
        foreach($event as $item){
            $eventnya[] = [
                'groupId' => $item->event_id,
                'title' => $item->agenda,
                'start' => $item->tanggal_awal,
                'end' => $item->tanggal_akhir,
            ];
        }
        $eventnya = json_encode($eventnya);
        return view('calendar.index', compact('data','event','eventnya'));
    }
    public function store(Request $request){
        $request->validate([
            'agenda' => ['required', 'string'],
            'tempat_event' => ['required'],
            // 'kehadiran' => ['required'],
            'tanggal_awal' => ['required'],
            'tanggal_akhir' => ['required'],
        ]);
        // $kehadiran = '|';
        // foreach($request->kehadiran as $item){
        //     $kehadiran .= $item.'|';
        // }
        // dd($kehadiran);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'agenda' => $request->agenda,
            'tempat_event' => $request->tempat_event,
            // 'kehadiran' => $kehadiran,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        DB::table('event')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        $departement = DB::table('departement')->whereNull('departement.deleted_at')->get();
        $data = DB::select("SELECT * FROM event WHERE event_id='$id'");
    // dd($departement);
        // return $text;
        return view('calendar.edit', compact('data','departement'));
    }

    public function update(Request $request){
        $request->validate([
            'agenda' => ['required', 'string'],
            'tempat_event' => ['required'],
            'tanggal_awal' => ['required'],
            'tanggal_akhir' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'agenda' => $request->agenda,
            'tempat_event' => $request->tempat_event,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'proyek_id' => session('proyek_aktif')['id'],
        ];
        $event_id = Crypt::decrypt($request->event_id);
        $status_event = "Aktif";
        DB::table('event')->where(['event_id' => $event_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('event')->where(['event_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
