@extends('layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Notulen Rapat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Dokumen Kontrol</li>
                    <li class="breadcrumb-item active">Notulen Rapat</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <strong>{{ $error }} <br></strong>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <h5 class="card-title">Notulen Rapat <button type="button" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-plus"></i> Tambah
                                </button></h5>

                            <!-- Table with stripped rows -->
                            <table class="table" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No Notulen Rapat</th>
                                        <th>Judul</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Tempat</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->no_notulen }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->tanggal_mulai_rapat }}</td>
                                            <td>{{ $item->tanggal_selesai_rapat }}</td>
                                            <td>{{ $item->tempat }}</td>
                                            <td>
                                                <a onclick="return dokumen({{ $item->notulen_id }})"
                                                    class="btn text-white btn-secondary"><i class="bi bi-book"></i></a>
                                                <a onclick="return edit({{ $item->notulen_id }})"
                                                    class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')"
                                                    href="{{ url('notulen/delete/' . Crypt::encrypt($item->notulen_id)) }}"
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

    </main>

    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('notulen/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">No Notulen</label>
                            <input type="text" class="form-control" id="no_notulen" name="no_notulen" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control" id="tanggal_mulai_rapat"
                                name="tanggal_mulai_rapat" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control" id="tanggal_selesai_rapat"
                                name="tanggal_selesai_rapat" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('notulen/update') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="tampildata"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="docModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="docModalLabel">Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="tampildoc"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function edit(id) {
            // let filter = $(this).attr('id'); 
            // filter = filter.split("-");
            // var tfilter = $(this).attr('id');
            // console.log(id);
            $.ajax({
                type: 'get',
                url: "{{ url('notulen/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {

                    // console.log(tampil); 
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }

        function dokumen(id) {
            $.ajax({
                type: 'get',
                url: "{{ url('notulen/doc') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#tampildoc').html(tampil);
                    $('#docModal').modal('show');
                }
            })
        }
    </script>
@endsection
