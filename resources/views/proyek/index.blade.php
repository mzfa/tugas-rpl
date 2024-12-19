@extends('layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Proyek</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Proyek</li>
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
                            <h5 class="card-title">Proyek <button type="button" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-plus"></i> Tambah
                                </button></h5>

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Nama Proyek</th>
                                            <th>Pemberi Tugas</th>
                                            <th>Manajemen Konstruksi</th>
                                            <th>Konsultan Perencana</th>
                                            <th>Kontraktor</th>
                                            <th>Sub Kontraktor</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Durasi Kontrak</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->nama_proyek }}</td>
                                                <td>{{ $item->pemberi_tugas }}</td>
                                                <td>{{ $item->manajemen_konstruksi }}</td>
                                                <td>{{ $item->konsultan_perencana }}</td>
                                                <td>{{ $item->kontraktor }}</td>
                                                <td>{{ $item->sub_kontraktor }}</td>
                                                <td>{{ $item->waktu_pelaksanaan_mulai }}</td>
                                                <td>{{ $item->waktu_pelaksanaan_berakhir }}</td>
                                                <td>{{ $item->durasi_kontrak }} Hari</td>
                                                <td>
                                                    <a onclick="return edit({{ $item->proyek_id }})"
                                                        class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                    <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')"
                                                        href="{{ url('proyek/delete/' . Crypt::encrypt($item->proyek_id)) }}"
                                                        class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
                                                    <a href="{{ url('proyek/detail/' . Crypt::encrypt($item->proyek_id)) }}"
                                                        class="btn text-white btn-info"><i class="bi bi-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('proyek/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Alamat Proyek</label>
                            <input type="text" class="form-control" id="alamat_proyek" name="alamat_proyek" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Pemberi Tugas</label>
                            <input type="text" class="form-control" id="pemberi_tugas" name="pemberi_tugas" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Manajemen Konstruksi</label>
                            <input type="text" class="form-control" id="manajemen_konstruksi" name="manajemen_konstruksi"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Konsultan Perencana</label>
                            <input type="text" class="form-control" id="konsultan_perencana" name="konsultan_perencana"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Kontraktor</label>
                            <input type="text" class="form-control" id="kontraktor" name="kontraktor" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Sub Kontraktor</label>
                            <input type="text" class="form-control" id="sub_kontraktor" name="sub_kontraktor"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Waktu Pelaksanaan Mulai</label>
                            <input type="date" class="form-control" id="waktu_pelaksanaan_mulai"
                                name="waktu_pelaksanaan_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Waktu Pelaksanaan Berakhir</label>
                            <input type="date" class="form-control" id="waktu_pelaksanaan_berakhir"
                                name="waktu_pelaksanaan_berakhir" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Luas Tanah</label>
                            <input type="text" class="form-control" id="luas_tanah" name="luas_tanah" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Luas Bangunan</label>
                            <input type="text" class="form-control" id="luas_bangunan" name="luas_bangunan" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Jumlah Lantai</label>
                            <input type="number" class="form-control" id="jumlah_lantai" name="jumlah_lantai" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Penggunaan</label>
                            <input type="text" class="form-control" id="penggunaan" name="penggunaan" required>
                        </div>
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Uraian Data</label>
                            <textarea class="form-control" name="uraian_data" id="" cols="30" rows="10"></textarea>
                        </div>
                        {{-- <div class="mb-3">
                        <label for="staticEmail" class="form-label">Pro Prof Pic</label>
                        <input type="text" class="form-control" id="pro_prof_pic" name="pro_prof_pic" required>
                    </div> --}}
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Lokasi</label>
                            <textarea name="lokasi" id="lokasi" cols="30" rows="10" class="form-control"></textarea>
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
            <form action="{{ url('proyek/update') }}" method="post">
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
@endsection

@section('scripts')
    <script>
        function edit(id) {
            $.ajax({
                type: 'get',
                url: "{{ url('proyek/edit') }}/" + id,
                success: function(tampil) {
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }
    </script>
@endsection
