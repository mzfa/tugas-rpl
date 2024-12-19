@extends('layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Dokumen Administrasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Dokumen Administrasi</li>
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
                            <h5 class="card-title">Dokumen Administrasi <button type="button" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-plus"></i> Tambah
                                </button></h5>

                            <!-- Table with stripped rows -->
                            <table class="table" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Kategori Dokumen</th>
                                        <th>No Dok</th>
                                        <th>Perihal Dok</th>
                                        <th>Tanggal Dok</th>
                                        <th>Keterangan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->keterangan_kategori_dokumen }}</td>
                                            <td>{{ $item->no_dokumen }}</td>
                                            <td>{{ $item->perihal_dokumen }}</td>
                                            <td>{{ $item->tanggal_dokumen }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                <a onclick="return dokumen({{ $item->dokumen_administrasi_id }})"
                                                    class="btn text-white btn-secondary"><i class="bi bi-book"></i></a>
                                                <a onclick="return edit({{ $item->dokumen_administrasi_id }})"
                                                    class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')"
                                                    href="{{ url('dok_adm/delete/' . Crypt::encrypt($item->dokumen_administrasi_id)) }}"
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
            <form action="{{ url('dok_adm/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Kategori Dokumen</label>
                            <select name="kategori_dokumen_id" id="" class="form-select" required>
                                <option value=""></option>
                                @foreach ($kategori_dokumen as $item)
                                    <option value="{{ $item->kategori_dokumen_id }}">
                                        {{ $item->keterangan_kategori_dokumen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">No Dokumen</label>
                            <input type="text" class="form-control" id="no_dokumen" name="no_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Perihal Dokumen</label>
                            <input type="text" class="form-control" id="perihal_dokumen" name="perihal_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="tanggal_dokumen" name="tanggal_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" required></textarea>
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
            <form action="{{ url('dok_adm/update') }}" method="post">
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
            $.ajax({
                type: 'get',
                url: "{{ url('dok_adm/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }

        function dokumen(id) {
            $.ajax({
                type: 'get',
                url: "{{ url('dok_adm/doc') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#tampildoc').html(tampil);
                    $('#docModal').modal('show');
                }
            })
        }
    </script>
@endsection
