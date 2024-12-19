@extends('layouts.app')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Menu</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Konfigurasi</li>
                    <li class="breadcrumb-item active">Menu</li>
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
                            <h5 class="card-title">Menu <button type="button" class="btn btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-plus"></i> Tambah
                                </button></h5>

                            <!-- Table with stripped rows -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Url</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menu as $item)
                                        <tr>
                                            <td>
                                                <h5>{{ strtoupper($item['nama_menu']) }}</h5>
                                                @if ($item['parent_id'] == 0)
                                                @else
                                                    <h5 class="text-primary">&nbsp;&nbsp;&nbsp;
                                                        {{ strtoupper($item['nama_menu']) }}</h5>
                                                @endif
                                            </td>
                                            <td>{{ $item['url_menu'] }}</td>
                                            <td>
                                                <a onclick="return edit({{ $item['menu_id'] }})"
                                                    class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                <a onclick="return tambahsubmenu({{ $item['menu_id'] }})"
                                                    class="btn text-white btn-primary"><i class="bi bi-plus"></i></a>
                                                @if (empty($item['submenu']))
                                                    <a href="{{ url('menu/delete/' . Crypt::encrypt($item['menu_id'])) }}"
                                                        class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @foreach ($item['submenu'] as $submenu)
                                            <tr>
                                                <td>
                                                    <p class="text-danger">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($submenu['nama_menu']) }}
                                                    </p>
                                                </td>
                                                <td>{{ $submenu['url_menu'] }}</td>
                                                <td>
                                                    <a onclick="return edit({{ $submenu['menu_id'] }})"
                                                        class="btn text-white btn-info"><i class="bi bi-pen"></i></a>
                                                    <a href="{{ url('menu/delete/' . Crypt::encrypt($submenu['menu_id'])) }}"
                                                        class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('menu/update') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ubah Menu</h5>
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
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('menu/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Url</label>
                            <input type="text" class="form-control" id="url_menu" name="url_menu">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon_menu" name="icon_menu">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="subMenuModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('menu/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Sub Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staticEmail" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Url</label>
                            <input type="text" class="form-control" id="url_menu" name="url_menu">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon_menu" name="icon_menu">
                        </div>
                    </div>
                    <input type="hidden" name="parent_id" id="parent_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                url: "{{ url('menu/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {

                    // console.log(tampil); 
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }

        function tambahsubmenu(id) {
            $('#parent_id').val(id);
            $('#subMenuModal').modal('show');
        }
    </script>
@endsection
