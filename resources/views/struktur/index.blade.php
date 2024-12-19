@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Struktur</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
                <div class="breadcrumb-item">Struktur</div>
            </div>
        </div>
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

        <div class="section-body">
            <h2 class="section-title">Struktur</h2>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Struktur</h4>
                            <div class="col-auto">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Struktur</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($struktur as $item)
                                            <tr class="bg-info">
                                                <td>
                                                    <h5 class="text-white">
                                                        {{ strtoupper($item['nama_struktur']) . ' | ' . $item['akronim'] }}
                                                        @if ($item['satusehat_id'] !== '' && $item['satusehat_id'] !== null)
                                                            <i class="fa fa-check"></i>
                                                        @endif
                                                    </h5>
                                                    @if ($item['parent_id'] == 0)
                                                    @else
                                                        <h5 class="text-primary">
                                                            {{ strtoupper($item['nama_struktur']) . ' | ' . $item['akronim'] }}
                                                        </h5>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a onclick="return edit({{ $item['struktur_id'] }})"
                                                        class="btn text-white btn-warning"><i class="fa fa-pen"></i></a>
                                                    <a onclick="return tambahsubstruktur({{ $item['struktur_id'] }})"
                                                        class="btn text-white btn-primary"><i class="fa fa-plus"></i></a>
                                                    @if (empty($item['substruktur']))
                                                        <a href="{{ url('struktur/delete/' . Crypt::encrypt($item['struktur_id'])) }}"
                                                            class="btn text-white btn-danger"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @foreach ($item['substruktur'] as $substruktur)
                                                <tr class="bg-primary">
                                                    <td>
                                                        <h5 class="text-white">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($substruktur['nama_struktur']) . ' | ' . $substruktur['akronim'] }}
                                                            @if ($substruktur['satusehat_id'] !== '' && $substruktur['satusehat_id'] !== null)
                                                                <i class="fa fa-check"></i>
                                                            @endif
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <a onclick="return edit({{ $substruktur['struktur_id'] }})"
                                                            class="btn text-white btn-warning"><i class="fa fa-pen"></i></a>
                                                        <a onclick="return tambahsubstruktur({{ $substruktur['struktur_id'] }})"
                                                            class="btn text-white btn-primary"><i
                                                                class="fa fa-plus"></i></a>
                                                        @if (empty($substruktur['substruktur1']))
                                                            <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur['struktur_id'])) }}"
                                                                class="btn text-white btn-danger"><i
                                                                    class="fa fa-trash"></i></a>
                                                        @endif
                                                        {{-- <a onclick="return edit({{ $substruktur['struktur_id'] }})"
                                                    class="btn text-white btn-info"><i class="fa fa-pen"></i></a>
                                                <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur['struktur_id'])) }}"
                                                    class="btn text-white btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                    </td>
                                                </tr>
                                                @foreach ($substruktur['substruktur1'] as $substruktur1)
                                                    <tr class="bg-success">
                                                        <td>
                                                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($substruktur1['nama_struktur']) . ' | ' . $substruktur1['akronim'] }}
                                                                @if ($substruktur1['satusehat_id'] !== '' && $substruktur1['satusehat_id'] !== null)
                                                                    <i class="fa fa-check"></i>
                                                                @endif
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <a onclick="return edit({{ $substruktur1['struktur_id'] }})"
                                                                class="btn text-white btn-warning"><i
                                                                    class="fa fa-pen"></i></a>
                                                            <a onclick="return tambahsubstruktur({{ $substruktur1['struktur_id'] }})"
                                                                class="btn text-white btn-primary"><i
                                                                    class="fa fa-plus"></i></a>
                                                            @if (empty($substruktur1['substruktur2']))
                                                                <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur1['struktur_id'])) }}"
                                                                    class="btn text-white btn-danger"><i
                                                                        class="fa fa-trash"></i></a>
                                                            @endif
                                                            {{-- <a onclick="return edit({{ $substruktur1['struktur_id'] }})"
                                                        class="btn text-white btn-info"><i class="fa fa-pen"></i></a>
                                                    <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur1['struktur_id'])) }}"
                                                        class="btn text-white btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                        </td>
                                                    </tr>
                                                    @foreach ($substruktur1['substruktur2'] as $substruktur2)
                                                        <tr class="bg-secondary">
                                                            <td>
                                                                <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($substruktur2['nama_struktur']) . ' | ' . $substruktur2['akronim'] }}
                                                                    @if ($substruktur2['satusehat_id'] !== '' && $substruktur2['satusehat_id'] !== null)
                                                                        <i class="fa fa-check"></i>
                                                                    @endif
                                                                </h5>
                                                            </td>
                                                            <td>
                                                                <a onclick="return edit({{ $substruktur2['struktur_id'] }})"
                                                                    class="btn text-white btn-warning"><i
                                                                        class="fa fa-pen"></i></a>
                                                                <a onclick="return tambahsubstruktur({{ $substruktur2['struktur_id'] }})"
                                                                    class="btn text-white btn-primary"><i
                                                                        class="fa fa-plus"></i></a>
                                                                @if (empty($substruktur2['substruktur3']))
                                                                    <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur2['struktur_id'])) }}"
                                                                        class="btn text-white btn-danger"><i
                                                                            class="fa fa-trash"></i></a>
                                                                @endif
                                                                {{-- <a onclick="return edit({{ $substruktur2['struktur_id'] }})"
                                                            class="btn text-white btn-info"><i class="fa fa-pen"></i></a>
                                                        <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur2['struktur_id'])) }}"
                                                            class="btn text-white btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                            </td>
                                                        </tr>
                                                        @foreach ($substruktur2['substruktur3'] as $substruktur3)
                                                            <tr>
                                                                <td>
                                                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($substruktur3['nama_struktur']) . ' | ' . $substruktur3['akronim'] }}
                                                                        @if ($substruktur3['satusehat_id'] !== '' && $substruktur3['satusehat_id'] !== null)
                                                                            <i class="fa fa-check"></i>
                                                                        @endif
                                                                    </h5>
                                                                </td>
                                                                <td>
                                                                    <a onclick="return edit({{ $substruktur3['struktur_id'] }})"
                                                                        class="btn text-white btn-warning"><i
                                                                            class="fa fa-pen"></i></a>
                                                                    <a onclick="return tambahsubstruktur({{ $substruktur3['struktur_id'] }})"
                                                                        class="btn text-white btn-primary"><i
                                                                            class="fa fa-plus"></i></a>
                                                                    @if (empty($substruktur3['substruktur3']))
                                                                        <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur3['struktur_id'])) }}"
                                                                            class="btn text-white btn-danger"><i
                                                                                class="fa fa-trash"></i></a>
                                                                    @endif
                                                                    {{-- <a onclick="return edit({{ $substruktur3['struktur_id'] }})"
                                                                class="btn text-white btn-info"><i class="fa fa-pen"></i></a>
                                                            <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur3['struktur_id'])) }}"
                                                                class="btn text-white btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                                </td>
                                                            </tr>
                                                            @foreach ($substruktur3['substruktur4'] as $substruktur4)
                                                                <tr class="bg-info text-white">
                                                                    <td>
                                                                        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ strtoupper($substruktur4['nama_struktur']) . ' | ' . $substruktur4['akronim'] }}
                                                                            @if ($substruktur4['satusehat_id'] !== '' && $substruktur4['satusehat_id'] !== null)
                                                                                <i class="fa fa-check"></i>
                                                                            @endif
                                                                        </h5>
                                                                    </td>
                                                                    <td>
                                                                        <a onclick="return edit({{ $substruktur4['struktur_id'] }})"
                                                                            class="btn text-white btn-warning"><i
                                                                                class="fa fa-pen"></i></a>
                                                                        <a onclick="return tambahsubstruktur({{ $substruktur4['struktur_id'] }})"
                                                                            class="btn text-white btn-primary"><i
                                                                                class="fa fa-plus"></i></a>
                                                                        @if (empty($substruktur4['substruktur4']))
                                                                            <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur4['struktur_id'])) }}"
                                                                                class="btn text-white btn-danger"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                        @endif
                                                                        {{-- <a onclick="return edit({{ $substruktur4['struktur_id'] }})"
                                                                    class="btn text-white btn-info"><i class="fa fa-pen"></i></a>
                                                                <a href="{{ url('struktur/delete/' . Crypt::encrypt($substruktur4['struktur_id'])) }}"
                                                                    class="btn text-white btn-danger"><i class="fa fa-trash"></i></a> --}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('struktur/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nama struktur</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_struktur" name="nama_struktur"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Akronim</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="akronim" name="akronim" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="substrukturModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="substrukturModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('struktur/store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nama_struktur" class="col-sm-2 col-form-label">Nama struktur</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_struktur" name="nama_struktur"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Akronim</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="akronim" name="akronim" required>
                            </div>
                        </div>
                        <input type="hidden" name="parent_id" id="parent_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('struktur/update') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="tampildata"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                url: "{{ url('struktur/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {

                    // console.log(tampil); 
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }

        function tambahsubstruktur(id) {
            $('#parent_id').val(id);
            $('#substrukturModal').modal('show');
        }
    </script>
@endsection
