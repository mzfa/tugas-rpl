@extends('layouts.app')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Material Approval</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                <li class="breadcrumb-item">Dokumen Kontrol</li>
                <li class="breadcrumb-item active">Material Approval</li>
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
                    <div class="card-body">
                        <h5 class="card-title">Material Approval <button type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#basicModal">
                                <i class="bi bi-plus"></i> Tambah
                            </button></h5>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No Material Approval</th>
                                        <th>Material</th>
                                        <th>Bidang</th>
                                        <th>Revisi Status</th>
                                        <th>Status Material</th>
                                        <th>Tanggal Submit</th>
                                        <th>Tanggal Dikembalikan</th>
                                        <th>Brand</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->no_material_approval }}</td>
                                            <td>{{ $item->perihal_material }}</td>
                                            <td>{{ $item->keterangan_bidang_pekerjaan }}</td>
                                            <td>{{ $item->revisi_status }}</td>
                                            <td>{{ $item->status_material }}</td>
                                            <td>{{ $item->tgl_dok_material }}</td>
                                            <td>{{ $item->tanggal_dikembalikan }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>
                                                <a onclick="return dokumen({{ $item->material_approval_id }})"
                                                    class="btn text-white btn-secondary"><i class="bi bi-book"></i></a>
                                                <a onclick="return edit({{ $item->material_approval_id }})"
                                                    class="btn text-white btn-warning"><i class="bi bi-pen"></i></a>
                                                <a onclick="return confirm('Apakah anda yakin ini akan di hapus?')" href="{{ url('material_approval/delete/' . Crypt::encrypt($item->material_approval_id)) }}" class="btn text-white btn-danger"><i class="bi bi-trash"></i></a>
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
        <form action="{{ url('material_approval/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">No Material Approval</label>
                        <input type="text" class="form-control" id="no_material_approval" name="no_material_approval" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Material</label>
                        <input type="text" class="form-control" id="perihal_material" name="perihal_material" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Tanggal Submit</label>
                        <input type="date" class="form-control" id="tgl_dok_material" name="tgl_dok_material" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggal_dikembalikan" name="tanggal_dikembalikan">
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Bidang Pekerjaan</label>
                        <select class="form-control" name="bidang_pekerjaan_id" id="bidang_pekerjaan_id">
                            <option value="">Pilih Bidang</option>
                            @foreach($bidang as $item)
                                <option value="{{ $item->bidang_pekerjaan_id }}">{{ $item->keterangan_bidang_pekerjaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Revisi Status</label>
                        <select class="form-control" name="revisi_status" id="revisi_status">
                            <option value="">Pilih Revisi Status</option>
                            <option value="R-0">R-0</option>
                            <option value="R-1">R-1</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Status Material</label>
                        <select class="form-control" name="status_material" id="status_material">
                            <option value="">Pilih Status Material</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Direvisi">Direvisi</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
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
      <form action="{{ url('material_approval/update') }}" method="post">
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
    function edit(id){
        // let filter = $(this).attr('id'); 
        // filter = filter.split("-");
        // var tfilter = $(this).attr('id');
        // console.log(id);
        $.ajax({ 
            type : 'get',
            url : "{{ url('material_approval/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){

                // console.log(tampil); 
                $('#tampildata').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
    function dokumen(id){
        $.ajax({ 
            type : 'get',
            url : "{{ url('material_approval/doc')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildoc').html(tampil);
                $('#docModal').modal('show');
            } 
        })
    }
</script>

@endsection