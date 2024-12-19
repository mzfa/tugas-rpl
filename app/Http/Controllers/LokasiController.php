<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = [];
        $data = DB::table('lokasi')->where(['parent_id' => 0])->whereNull('deleted_at')->get();
        
        // dd($data);
        foreach($data as $key => $item)
        {
            array_push($lokasi, [
                'lokasi_id' => $item->lokasi_id,
                'nama_lokasi' => $item->nama_lokasi,
                'parent_id' => $item->parent_id,
                'akronim' => $item->akronim,
                'satusehat_id' => $item->satusehat_id,
                'sublokasi' => []
            ]);
            $lokasi_id = $item->lokasi_id;
            $sublokasi1 = DB::table('lokasi')->where(['parent_id' => $lokasi_id])->whereNull('deleted_at')->get();
            // dd($sublokasi1);
            foreach($sublokasi1 as $key1 => $sub1)
            {
                array_push($lokasi[$key]["sublokasi"], [
                    "lokasi_id" => $sub1->lokasi_id,
                    "nama_lokasi" => $sub1->nama_lokasi,
                    "akronim" => $sub1->akronim,
                    "satusehat_id" => $sub1->satusehat_id,
                    'sublokasi1' => [],
                ]);

                $lokasi_id1 = $sub1->lokasi_id;
                $sublokasi2 = DB::table('lokasi')->where(['parent_id' => $lokasi_id1])->whereNull('deleted_at')->get();
                // dd($lokasi['sublokasi']);
                foreach($sublokasi2 as $key2 => $sub2)
                {
                    // dd($key1);
                    array_push($lokasi[$key]["sublokasi"][$key1]["sublokasi1"], [
                        "lokasi_id" => $sub2->lokasi_id,
                        "nama_lokasi" => $sub2->nama_lokasi,
                        "akronim" => $sub2->akronim,
                        "satusehat_id" => $sub2->satusehat_id,
                        'sublokasi2' => [],
                    ]);

                    $lokasi_id2 = $sub2->lokasi_id;
                    $sublokasi3 = DB::table('lokasi')->where(['parent_id' => $lokasi_id2])->whereNull('deleted_at')->get();
                    // dd($lokasi['sublokasi']);
                    foreach($sublokasi3 as $key3 => $sub3)
                    {
                        array_push($lokasi[$key]["sublokasi"][$key1]["sublokasi1"][$key2]["sublokasi2"], [
                            "lokasi_id" => $sub3->lokasi_id,
                            "nama_lokasi" => $sub3->nama_lokasi,
                            "akronim" => $sub3->akronim,
                            "satusehat_id" => $sub3->satusehat_id,
                            'sublokasi3' => [],
                        ]);

                        $lokasi_id3 = $sub3->lokasi_id;
                        $sublokasi4 = DB::table('lokasi')->where(['parent_id' => $lokasi_id3])->whereNull('deleted_at')->get();
                        // dd($lokasi['sublokasi']);
                        foreach($sublokasi4 as $key4 => $sub4)
                        {
                            array_push($lokasi[$key]["sublokasi"][$key1]["sublokasi1"][$key2]["sublokasi2"][$key3]["sublokasi3"], [
                                "lokasi_id" => $sub4->lokasi_id,
                                "nama_lokasi" => $sub4->nama_lokasi,
                                "akronim" => $sub4->akronim,
                                "satusehat_id" => $sub4->satusehat_id,
                                'sublokasi4' => [],
                            ]);

                            $lokasi_id4 = $sub4->lokasi_id;
                            $sublokasi5 = DB::table('lokasi')->where(['parent_id' => $lokasi_id4])->whereNull('deleted_at')->get();

                            foreach($sublokasi5 as $key5 => $sub5)
                            {
                                array_push($lokasi[$key]["sublokasi"][$key1]["sublokasi1"][$key2]["sublokasi2"][$key3]["sublokasi3"][$key4]["sublokasi4"], [
                                    "lokasi_id" => $sub5->lokasi_id,
                                    "nama_lokasi" => $sub5->nama_lokasi,
                                    "akronim" => $sub5->akronim,
                                    "satusehat_id" => $sub5->satusehat_id,
                                    'sublokasi5' => [],
                                ]);

                                $lokasi_id5 = $sub5->lokasi_id;
                                $sublokasi6 = DB::table('lokasi')->where(['parent_id' => $lokasi_id5])->whereNull('deleted_at')->get();
                                // dd($lokasi['sublokasi']);
                            }

                        }
                    }
                }
            }
        }
        // dd($lokasi);
        return view('lokasi.index', compact('lokasi'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_lokasi' => ['required', 'string'],
        ]);
        $parent_id = 0;
        if(isset($request->parent_id)){
            $parent_id = $request->parent_id;
        }
        $data = [
            'nama_lokasi' => $request->nama_lokasi,
            'akronim' => $request->akronim,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'parent_id' => $parent_id,
        ];

        DB::table('lokasi')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $lokasi = DB::table('lokasi')->get();
        $struktur = DB::table('struktur')->whereNull('deleted_at')->whereNotNull('satusehat_id')->get();
        // dd($lokasi);
        $text = "Data tidak ditemukan";
        if($data = DB::table('lokasi')->where(['lokasi_id' => $id])->first()){

            // $text = '<div class="mb-3 row">'.
            //         '<label for="staticEmail" class="col-sm-2 col-form-label">Nama lokasi</label>'.
            //         '<div class="col-sm-10">'.
            //         '<input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" value="'.$data->nama_lokasi.'" required>'.
            //         '</div>'.
            //     '</div>'.
            //     '<div class="mb-3 row">'.
            //         '<label for="staticEmail" class="col-sm-2 col-form-label">Akronim (Singkatan)</label>'.
            //         '<div class="col-sm-10">'.
            //         '<input type="text" class="form-control" id="akronim" name="akronim" value="'.$data->akronim.'" required>'.
            //         '</div>'.
            //     '</div>'.
            //     '<div class="mb-3 row">'.
            //         '<label for="staticEmail" class="col-sm-2 col-form-label">Akronim (Singkatan)</label>'.
            //         '<div class="col-sm-10">'.
            //         '<select class="form-control" name="parent_id">';
            //             foreach($lokasi as $item){
            //                 $text .= '<option value="'.$item->lokasi_id.'" '.($item->lokasi_id == $data->parent_id) ?? "selected".'>'.$item->nama_lokasi.'</option>';
            //             }
            //         $text .= '</select>'.
            //         '</div>'.
            //     '</div>'.
            //     '<input type="hidden" class="form-control" id="lokasi_id" name="lokasi_id" value="'.Crypt::encrypt($data->lokasi_id) .'" required>';
            return view('lokasi.edit', compact('lokasi','data','struktur'));
        }
        return $text;
        // return view('admin.lokasi.edit');
    }

    public function update(Request $request){

        $request->validate([
            'nama_lokasi' => ['required', 'string'],
        ]);
        $data_id = explode('|',$request->struktur_id);
        $satusehat_id = $data_id[0];
        $struktur_id = $data_id[1];

        // $res = '{"description":"Rumah sakit Umm Pekerja","id":"9542115e-ca4b-4229-90e1-cf90a54fd7b5","identifier":[{"system":"http://sys-ids.kemkes.go.id/location/28c7f233-4382-4fff-aeca-7f1e5174ba74"}],"managingOrganization":{"reference":"Organization/bb14e1fe-d768-471b-9c64-c5d12272bcec"},"meta":{"lastUpdated":"2023-11-18T15:07:50.333600+00:00","versionId":"MTcwMDMyMDA3MDMzMzYwMDAwMA"},"mode":"instance","name":"Rumah Sakit","physicalType":{"coding":[{"code":"ro","display":"Room","system":"http://terminology.hl7.org/CodeSystem/location-physical-type"}]},"position":{"altitude":0,"latitude":106.92328071534288,"longitude":-6.145125196879691},"resourceType":"Location","status":"active"}"\"{\\\"description\\\":\\\"Rumah sakit Umm Pekerja\\\",\\\"id\\\":\\\"9542115e-ca4b-4229-90e1-cf90a54fd7b5\\\",\\\"identifier\\\":[{\\\"system\\\":\\\"http:\\\/\\\/sys-ids.kemkes.go.id\\\/location\\\/28c7f233-4382-4fff-aeca-7f1e5174ba74\\\"}],\\\"managingOrganization\\\":{\\\"reference\\\":\\\"Organization\\\/bb14e1fe-d768-471b-9c64-c5d12272bcec\\\"},\\\"meta\\\":{\\\"lastUpdated\\\":\\\"2023-11-18T15:07:50.333600+00:00\\\",\\\"versionId\\\":\\\"MTcwMDMyMDA3MDMzMzYwMDAwMA\\\"},\\\"mode\\\":\\\"instance\\\",\\\"name\\\":\\\"Rumah Sakit\\\",\\\"physicalType\\\":{\\\"coding\\\":[{\\\"code\\\":\\\"ro\\\",\\\"display\\\":\\\"Room\\\",\\\"system\\\":\\\"http:\\\/\\\/terminology.hl7.org\\\/CodeSystem\\\/location-physical-type\\\"}]},\\\"position\\\":{\\\"altitude\\\":0,\\\"latitude\\\":106.92328071534288,\\\"longitude\\\":-6.145125196879691},\\\"resourceType\\\":\\\"Location\\\",\\\"status\\\":\\\"active\\\"}\""';

        // $res = json_decode($res);
        // dd($res);
        if(isset($request->satusehat_id)){
            dd('ok');
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => env('BASE_URL_SATU_SEHAT').'api/lokasi/'.$satusehat_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => 'nama_lokasi='.$request->nama_lokasi.'&organisasi='.$satusehat_id.'&keterangan_lokasi='.$request->keterangan_lokasi,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response);
            // $res = json_decode($res);
            if(empty($res->id)){
                dd($response);
            }
            // dd($res);

        }else{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => env('BASE_URL_SATU_SEHAT').'api/lokasi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('nama_lokasi' => $request->nama_lokasi,'organisasi' => $satusehat_id,'keterangan_lokasi' => $request->keterangan_lokasi),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            $res = json_decode($response);
            if(empty($res->id)){
                dd($response);
            }
            $satusehat_id = $res->id;
            // dd($res);
        }
        // dd($satusehat_id);

        $data = [
            'nama_lokasi' => $request->nama_lokasi,
            'akronim' => $request->akronim,
            'parent_id' => $request->parent_id,
            'keterangan_lokasi' => $request->keterangan_lokasi,
            'satusehat_id' => $satusehat_id,
            'struktur_id' => $struktur_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ];
        $lokasi_id = Crypt::decrypt($request->lokasi_id);
        DB::table('lokasi')->where(['lokasi_id' => $lokasi_id])->update($data);


        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete($id){
        $id = Crypt::decrypt($id);
        // if($data = DB::select("SELECT * FROM tbl_lokasi WHERE lokasi_id='$id'")){
        //     DB::select("DELETE FROM tbl_lokasi WHERE lokasi_id='$id'");
        // }
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('lokasi')->where(['lokasi_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
