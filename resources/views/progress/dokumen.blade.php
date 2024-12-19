@extends('layouts.tamplate')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Default Tabs Justified</h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                                    aria-selected="true"><h2>Dokumen Proses</h2></button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-justified" type="button" role="tab"
                                    aria-controls="profile" aria-selected="false" tabindex="-1"><h2>File Progress</h2></button>
                            </li>
                            {{-- <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact-justified" type="button" role="tab"
                                    aria-controls="contact" aria-selected="false" tabindex="-1">Contact</button>
                            </li> --}}
                        </ul>
                        <div class="tab-content pt-2" id="myTabjustifiedContent">
                            <div class="tab-pane fade show active" id="home-justified" role="tabpanel"
                                aria-labelledby="home-tab">
                                <h5 class="card-title">Dokumen Progress</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Progress <button type="button" class="btn btn-primary"
                                                onclick="document.getElementById('tambah_dokumen_proses').style.display = 'block'">
                                                <i class="bi bi-plus"></i> Tambah
                                            </button></h5>
                                        <div id="tambah_dokumen_proses" style="display: none">
                                            <form action="{{ url('progres/progress_detail_store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title" id="staticBackdropLabel">Tambah Data</h5>
                                                    </div>
                                                    <input type="hidden" name="progress_id" value="{{ $id }}">
                                                    <div class="card-body row">
                                                        <div class="col-12 mb-3">
                                                            <label for="staticEmail" class="form-label">Jenis Pekerjaan</label>
                                                            <select class="form-control" name="jenis_pekerjaan_id" id="jenis_pekerjaan_id">
                                                                <option value="">Pilih Jenis Pekerjaan</option>
                                                                @foreach ($jenis_pekerjaan as $item)
                                                                    <option value="{{ $item->jenis_pekerjaan_id }}">{{ $item->nama_jenis_pekerjaan }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Bobot (%)</label>
                                                            <input type="text" class="form-control" id="bobot" name="bobot" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Bobot Rencana(%)</label>
                                                            <input type="text" class="form-control" id="bobot_rencana" name="bobot_rencana" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Prestasi Minggu Lalu</label>
                                                            <input type="text" class="form-control" id="prestasi_minggu_lalu" name="prestasi_minggu_lalu" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Bobot Minggu Lalu</label>
                                                            <input type="text" class="form-control" id="bobot_minggu_lalu" name="bobot_minggu_lalu" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Prestasi Minggu Ini</label>
                                                            <input type="text" class="form-control" id="prestasi_minggu_ini" name="prestasi_minggu_ini" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Bobot Minggu Ini</label>
                                                            <input type="text" class="form-control" id="bobot_minggu_ini" name="bobot_minggu_ini" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Prestasi s/d Minggu Ini</label>
                                                            <input type="text" class="form-control" id="prestasi_sd_minggu_ini" name="prestasi_sd_minggu_ini" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Bobot s/d Minggu Ini</label>
                                                            <input type="text" class="form-control" id="bobot_sd_minggu_ini" name="bobot_sd_minggu_ini" required>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-info" onclick="document.getElementById('tambah_dokumen_proses').style.display = 'none'">Hide</button>
                                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="editDokumenProses" style="display: none">
                                            <form action="{{ url('progres/progres_detail_update') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title" id="staticBackdropLabel">Ubah Data</h5>
                                                    </div>
                                                    <div class="card-body row" id="tampiEditlDokumenProses">
                                                        
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-info" onclick="document.getElementById('editDokumenProses').style.display = 'none'">Hide</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Table with stripped rows -->
                                        <table class="table table-bordered" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th colspan="4"></th>
                                                    <th colspan="2" class="text-center">Minggu Lalu</th>
                                                    <th colspan="2" class="text-center">Minggu Ini</th>
                                                    <th colspan="2" class="text-center">s/d Minggu Ini</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jenis Pekerjaan</th>
                                                    <th>Bobot (%)</th>
                                                    <th>Bobot Rencana (%)</th>
                                                    <th>Prestasi Minggu Lalu</th>
                                                    <th>Bobot Minggu Lalu</th>
                                                    <th>Prestasi Minggu Ini</th>
                                                    <th>Bobot Minggu Ini</th>
                                                    <th>Prestasi s/d Minggu Ini</th>
                                                    <th>Bobot s/d Minggu Ini</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                    $bobot = 0;
                                                    $bobot_rencana = 0;
                                                    $prestasi_minggu_lalu = 0;
                                                    $bobot_minggu_lalu = 0;
                                                    $prestasi_minggu_ini = 0;
                                                    $bobot_minggu_ini = 0;
                                                    $prestasi_sd_minggu_ini = 0;
                                                    $bobot_sd_minggu_ini = 0;
                                                @endphp
                                                @foreach ($progress_detail as $item)
                                                    @php
                                                        $bobot += (float) $item->bobot;
                                                        $bobot_rencana += (float) $item->bobot_rencana;
                                                        $prestasi_minggu_lalu += (float) $item->prestasi_minggu_lalu;
                                                        $bobot_minggu_lalu += (float) $item->bobot_minggu_lalu;
                                                        $prestasi_minggu_ini += (float) $item->prestasi_minggu_ini;
                                                        $bobot_minggu_ini += (float) $item->bobot_minggu_ini;
                                                        $prestasi_sd_minggu_ini += (float) $item->prestasi_sd_minggu_ini;
                                                        $bobot_sd_minggu_ini += (float) $item->bobot_sd_minggu_ini;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama_jenis_pekerjaan }}</td>
                                                        <td>{{ $item->bobot }}</td>
                                                        <td>{{ $item->bobot_rencana }}</td>
                                                        <td>{{ $item->prestasi_minggu_lalu }}</td>
                                                        <td>{{ $item->bobot_minggu_lalu }}</td>
                                                        <td>{{ $item->prestasi_minggu_ini }}</td>
                                                        <td>{{ $item->bobot_minggu_ini }}</td>
                                                        <td>{{ $item->prestasi_sd_minggu_ini }}</td>
                                                        <td>{{ $item->bobot_sd_minggu_ini }}</td>
                                                        <td>
                                                            <button onclick="return edit({{ $item->progress_detail_id }})"  class="btn btn-warning">Edit</button>
                                                            <a href="" class="btn btn-danger">Hapus</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="text-danger">
                                                    <th>-</th>
                                                    <th>Total</th>
                                                    <th>{{ $bobot }}</th>
                                                    <th>{{ $bobot_rencana }}</th>
                                                    <th>{{ $prestasi_minggu_lalu }}</th>
                                                    <th>{{ $bobot_minggu_lalu }}</th>
                                                    <th>{{ $prestasi_minggu_ini }}</th>
                                                    <th>{{ $bobot_minggu_ini }}</th>
                                                    <th>{{ $prestasi_sd_minggu_ini }}</th>
                                                    <th>{{ $bobot_sd_minggu_ini }}</th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Table with stripped rows -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                                <h5 class="card-title">Dokumen Progress</h5>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Tambah Dokumen</h5>
                                        <form class="row g-3" action="{{ url('progres/store_doc') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                                    onclick="cek_checkbox()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">File Berupa
                                                    Link</label>
                                            </div>
                                            <div class="col-12" id="fileInput">
                                                <label for="inputNumber" class="col-sm-2 col-form-label">Upload File</label>
                                                <input class="form-control" type="file" id="formFile" name="file">
                                            </div>
                                            <div class="col-12" id="link_dokumen" style="display: none">
                                                <label for="inputPassword4" class="form-label">Link File</label>
                                                <input type="text" class="form-control" name="link_dokumen">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputEmail4" class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" id="keterangan"
                                                    name="keterangan">
                                            </div>
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Table with stripped rows -->
                                <table class="table" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>Nama Dokumen</th>
                                            <th>Link</th>
                                            <th>Keterangan</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td><a target="_blank"
                                                        href="{{ url('dokumen/surat/' . $item->nama_file) }}">{{ $item->nama_file ?? '-' }}</a>
                                                </td>
                                                <td>{{ $item->link_dokumen ?? '-' }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')"
                                                        href="{{ url('progres/delete_doc/' . Crypt::encrypt($item->dokumen_id)) }}"
                                                        class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        function cek_checkbox() {
            var elm = document.getElementById('flexSwitchCheckChecked');
            var elmLink = document.getElementById('link_dokumen');
            var elmDoc = document.getElementById('fileInput');
            if (elm.checked == true) {
                elmLink.style.display = "block";
                elmDoc.style.display = "none";
            } else {
                elmLink.style.display = "none";
                elmDoc.style.display = "block";
            }
            // console.log(elm.value);
        }

        function edit(id) {
            $.ajax({
                type: 'get',
                url: "{{ url('progres/progres_detail_edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    document.getElementById('editDokumenProses').style.display = 'block';
                    $('#tampiEditlDokumenProses').html(tampil);
                }
            })
        }
        function tambah(id) {
            $('#tampildata').html(tampil);
        }
    </script>
@endsection
