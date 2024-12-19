@extends('layouts.tamplate')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dokumen Administrasi</h5>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Tambah Dokumen</h5>
                                <form class="row g-3" action="{{ url('dok_adm/store_doc') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" onclick="cek_checkbox()">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">File Berupa Link</label>
                                    </div>
                                    <div class="col-12" id="fileInput" >
                                        <label for="inputNumber" class="col-sm-2 col-form-label">Upload File</label>
                                        <input class="form-control" type="file" id="formFile" name="file">
                                    </div>
                                    <div class="col-12" id="link_dokumen" style="display: none">
                                        <label for="inputPassword4" class="form-label">Link File</label>
                                        <input type="text" class="form-control" name="link_dokumen">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputEmail4" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" id="keterangan" name="keterangan">
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
                                        <td><a target="_blank" href="{{ url('dokumen/dokumen_administrasi/'.$item->nama_file) }}">{{ $item->nama_file ?? '-' }}</a></td>
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
                                                href="{{ url('dok_adm/delete_doc/' . Crypt::encrypt($item->dokumen_id)) }}"
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
                url: "{{ url('dok_adm/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#tampildata').html(tampil);
                    $('#editDocModal').modal('show');
                }
            })
        }
    </script>
@endsection
