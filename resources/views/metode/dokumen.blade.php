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
                                    aria-controls="profile" aria-selected="false" tabindex="-1"><h2>File Metode</h2></button>
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
                                <h5 class="card-title">Dokumen Proses</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Dokumen Proses <button type="button" class="btn btn-primary"
                                                onclick="document.getElementById('tambah_dokumen_proses').style.display = 'block'">
                                                <i class="bi bi-plus"></i> Tambah
                                            </button></h5>
                                        <div id="tambah_dokumen_proses" style="display: none">
                                            <form action="{{ url('metode/dokumen_proses_store') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title" id="staticBackdropLabel">Tambah Data</h5>
                                                    </div>
                                                    <div class="card-body row">
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Tanggal Terima Dokumen</label>
                                                            <input type="datetime-local" class="form-control" id="tanggal_terima_dok" name="tanggal_terima_dok" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Pihak Pemroses Dokumen</label>
                                                            <select class="form-control" name="status_proses_dok" id="status_proses_dok">
                                                                <option value="">Pilih Revisi Status</option>
                                                                <option value="Diperiksa">Diperiksa</option>
                                                                <option value="Disetujui">Disetujui</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Status Proses Dokumen</label>
                                                            <select class="form-control" name="departement_id" id="departement_id">
                                                                <option value="">Pilih Departement Pemroses</option>
                                                                @foreach ($departement as $item)
                                                                    <option value="{{ $item->departement_id }}">{{ $item->nama_departement }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="staticEmail" class="form-label">Durasi (hari)</label>
                                                            <input type="number" class="form-control" id="durasi" name="durasi" required>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="staticEmail" class="form-label">Catatan</label>
                                                            <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control"></textarea>
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
                                            <form action="{{ url('metode/dokumen_proses_update') }}" method="post" enctype="multipart/form-data">
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
                                        <table class="table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Terima Dok</th>
                                                    <th>Pihak Proses Dok</th>
                                                    <th>Status Proses</th>
                                                    <th>Tanggal Status</th>
                                                    <th>Durasi(hari)</th>
                                                    <th>Catatan</th>
                                                    <th>Tanggal Diubah</th>
                                                    <th>Diubah Oleh</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_dokumen_proses as $item)
                                                    <tr>
                                                        <td>{{ $item->tanggal_terima_dok }}</td>
                                                        <td>{{ $item->nama_departement }}</td>
                                                        <td>{{ $item->status_proses_dok }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>{{ $item->durasi }} Hari</td>
                                                        <td>{{ $item->catatan }}</td>
                                                        <td>{{ $item->updated_at ?? "-" }}</td>
                                                        <td>{{ $item->username }}</td>
                                                        <td>
                                                            <a onclick="return edit({{ $item->dokumen_proses_metode_id }})"
                                                                class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                            <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')" href="{{ url('metode/delete_proses_store/' . Crypt::encrypt($item->dokumen_proses_metode_id)) }}" class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- End Table with stripped rows -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                                <h5 class="card-title">File Metode</h5>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Tambah Dokumen</h5>
                                        <form class="row g-3" action="{{ url('metode/store_doc') }}"
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
                                            <th>Comment</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td><a target="_blank"
                                                        href="{{ url('dokumen/metode/' . $item->nama_file) }}">{{ $item->nama_file ?? '-' }}</a>
                                                </td>
                                                <td>{{ $item->link_dokumen ?? '-' }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    <form action="{{ url('doc_command/') }}" method="post">
                                                        <div class="form-group">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $item->dokumen_id }}">
                                                            <input type="text" class="form-control mb-1" name="command">
                                                            <button type="submit" class="btn btn-success btn-block w-100 mb-2"><i class="bi bi-chat-right-dots"></i> &nbsp; Submit</button>
                                                            @isset($commandnya[$item->dokumen_id])
                                                                @foreach ($commandnya[$item->dokumen_id] as $command)
                                                                    <em>{{ $command['user'].' : '. $command['isi_command'] }}</em><br>
                                                                @endforeach
                                                            @endisset
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')"
                                                        href="{{ url('metode/delete_doc/' . Crypt::encrypt($item->dokumen_id)) }}"
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
                url: "{{ url('metode/dokumen_proses_edit') }}/" + id,
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
