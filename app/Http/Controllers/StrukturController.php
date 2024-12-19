<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = [];
        $data = DB::table('struktur')->where(['parent_id' => 0])->whereNull('deleted_at')->get();
        // dd($data);
        foreach($data as $key => $item)
        {
            array_push($struktur, [
                'struktur_id' => $item->struktur_id,
                'nama_struktur' => $item->nama_struktur,
                'parent_id' => $item->parent_id,
                'akronim' => $item->akronim,
                'satusehat_id' => $item->satusehat_id,
                'substruktur' => []
            ]);
            $struktur_id = $item->struktur_id;
            $substruktur1 = DB::table('struktur')->where(['parent_id' => $struktur_id])->whereNull('deleted_at')->get();
            // dd($substruktur1);
            foreach($substruktur1 as $key1 => $sub1)
            {
                array_push($struktur[$key]["substruktur"], [
                    "struktur_id" => $sub1->struktur_id,
                    "nama_struktur" => $sub1->nama_struktur,
                    "akronim" => $sub1->akronim,
                    "satusehat_id" => $sub1->satusehat_id,
                    'substruktur1' => [],
                ]);

                $struktur_id1 = $sub1->struktur_id;
                $substruktur2 = DB::table('struktur')->where(['parent_id' => $struktur_id1])->whereNull('deleted_at')->get();
                // dd($struktur['substruktur']);
                foreach($substruktur2 as $key2 => $sub2)
                {
                    // dd($key1);
                    array_push($struktur[$key]["substruktur"][$key1]["substruktur1"], [
                        "struktur_id" => $sub2->struktur_id,
                        "nama_struktur" => $sub2->nama_struktur,
                        "akronim" => $sub2->akronim,
                        "satusehat_id" => $sub2->satusehat_id,
                        'substruktur2' => [],
                    ]);

                    $struktur_id2 = $sub2->struktur_id;
                    $substruktur3 = DB::table('struktur')->where(['parent_id' => $struktur_id2])->whereNull('deleted_at')->get();
                    // dd($struktur['substruktur']);
                    foreach($substruktur3 as $key3 => $sub3)
                    {
                        array_push($struktur[$key]["substruktur"][$key1]["substruktur1"][$key2]["substruktur2"], [
                            "struktur_id" => $sub3->struktur_id,
                            "nama_struktur" => $sub3->nama_struktur,
                            "akronim" => $sub3->akronim,
                            "satusehat_id" => $sub3->satusehat_id,
                            'substruktur3' => [],
                        ]);

                        $struktur_id3 = $sub3->struktur_id;
                        $substruktur4 = DB::table('struktur')->where(['parent_id' => $struktur_id3])->whereNull('deleted_at')->get();
                        // dd($struktur['substruktur']);
                        foreach($substruktur4 as $key4 => $sub4)
                        {
                            array_push($struktur[$key]["substruktur"][$key1]["substruktur1"][$key2]["substruktur2"][$key3]["substruktur3"], [
                                "struktur_id" => $sub4->struktur_id,
                                "nama_struktur" => $sub4->nama_struktur,
                                "akronim" => $sub4->akronim,
                                "satusehat_id" => $sub4->satusehat_id,
                                'substruktur4' => [],
                            ]);

                            $struktur_id4 = $sub4->struktur_id;
                            $substruktur5 = DB::table('struktur')->where(['parent_id' => $struktur_id4])->whereNull('deleted_at')->get();

                            foreach($substruktur5 as $key5 => $sub5)
                            {
                                array_push($struktur[$key]["substruktur"][$key1]["substruktur1"][$key2]["substruktur2"][$key3]["substruktur3"][$key4]["substruktur4"], [
                                    "struktur_id" => $sub5->struktur_id,
                                    "nama_struktur" => $sub5->nama_struktur,
                                    "akronim" => $sub5->akronim,
                                    "satusehat_id" => $sub5->satusehat_id,
                                    'substruktur5' => [],
                                ]);

                                $struktur_id5 = $sub5->struktur_id;
                                $substruktur6 = DB::table('struktur')->where(['parent_id' => $struktur_id5])->whereNull('deleted_at')->get();
                                // dd($struktur['substruktur']);
                            }

                        }
                    }
                }
            }
        }
        // dd($struktur);
        return view('struktur.index', compact('struktur'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_struktur' => ['required', 'string'],
        ]);
        $parent_id = 0;
        if(isset($request->parent_id)){
            $parent_id = $request->parent_id;
        }
        $data = [
            'nama_struktur' => $request->nama_struktur,
            'akronim' => $request->akronim,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'parent_id' => $parent_id,
        ];

        DB::table('struktur')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $struktur = DB::table('struktur')->get();
        // dd($struktur);
        $text = "Data tidak ditemukan";
        if($data = DB::table('struktur')->where(['struktur_id' => $id])->first()){
            return view('struktur.edit', compact('struktur','data'));
        }
        return $text;
        // return view('admin.struktur.edit');
    }

    public function update(Request $request){

        $request->validate([
            'nama_struktur' => ['required', 'string'],
        ]);
        $satusehat_id = $request->satusehat_id;

        $referensi_id = '';
        $parent = DB::table('struktur')->where(['struktur_id' => $request->parent_id])->first();
        if(isset($parent)){
            $referensi_id = $parent->satusehat_id;
        }
        // $res = json_decode('{"active":true,"address":[{"city":"Jakarta","country":"ID","extension":[{"extension":[{"url":"province","valueCode":"31"},{"url":"city","valueCode":"3172"},{"url":"district","valueCode":"317204"},{"url":"village","valueCode":"3172041002"}],"url":"https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode"}],"line":["Jl. Tipar Cakung No.46, RT.2/RW.1, Sukapura Kec. Cilincing, Jkt Utara, Daerah Khusus Ibukota Jakarta"],"postalCode":"14140","type":"both","use":"work"}],"id":"2c0eaa43-09ed-4516-a0b9-9f7c309c6744","identifier":[{"system":"http://sys-ids.kemkes.go.id/organization/28c7f233-4382-4fff-aeca-7f1e5174ba74","use":"official"}],"meta":{"lastUpdated":"2023-11-18T04:16:01.921750+00:00","versionId":"MTcwMDI4MDk2MTkyMTc1MDAwMA"},"name":"SEKERTARIS - RS UMUM PEKERJA","partOf":{"reference":"Organization/bb14e1fe-d768-471b-9c64-c5d12272bcec"},"resourceType":"Organization","telecom":[{"system":"phone","use":"work","value":"+6285777789022"},{"system":"email","use":"work","value":"rumah.sakit.pekerja@gmail.com"},{"system":"url","use":"work","value":"www.webrs.rsumumpekerja-kbn.com"}],"type":[{"coding":[{"code":"dept","display":"Hospital Department","system":"http://terminology.hl7.org/CodeSystem/organization-type"}]}]}');

        // dd($res->id);
        if(isset($request->satusehat_id)){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => env('BASE_URL_SATU_SEHAT').'api/organisasi/'.$satusehat_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => 'nama_organisasi='.$request->nama_struktur.'&id='.$satusehat_id.'&referensi='.$referensi_id,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response);
            $res = json_decode($res);
            if(empty($res->id)){
                dd($response);
            }
            // dd($res);

        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => env('BASE_URL_SATU_SEHAT').'api/organisasi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('nama_organisasi' => $request->nama_struktur,'referensi' => $referensi_id),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            $res = json_decode($response);
            $res = json_decode($res);
            if(empty($res->id)){
                dd($response);
            }
            $satusehat_id = $res->id;
            // dd($res);
        }
        // dd($satusehat_id);

        $data = [
            'nama_struktur' => $request->nama_struktur,
            'akronim' => $request->akronim,
            'parent_id' => $request->parent_id,
            'satusehat_id' => $satusehat_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ];
        $struktur_id = Crypt::decrypt($request->struktur_id);
        DB::table('struktur')->where(['struktur_id' => $struktur_id])->update($data);


        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete($id){
        $id = Crypt::decrypt($id);
        // if($data = DB::select("SELECT * FROM tbl_struktur WHERE struktur_id='$id'")){
        //     DB::select("DELETE FROM tbl_struktur WHERE struktur_id='$id'");
        // }
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('struktur')->where(['struktur_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
