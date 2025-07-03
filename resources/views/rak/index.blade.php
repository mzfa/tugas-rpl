@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Rak</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Rak</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Data Rak</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#basicModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="display table table-bordered dataTable no-footer" id="buttons-datatables">
                                    <thead>
                                        <tr>
                                            <th>Nama Gudang</th>
                                            <th>Nama Rak</th>
                                            <th>Kapasitas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->nama_gudang }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kapasitas }}</td>
                                                <td>
                                                    <button onclick="edit('{{ $item->rak_id }}')" class="btn btn-primary"> Edit</button>
                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item->rak_id }}')"
                                                            class="btn btn-danger text-white">Hapus</a>
                                                    <a target="_blank" href="{{ url('rak/barcode/'.$item->rak_id) }}" class="btn btn-warning text-white">Barcode</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</div>

<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ url('rak/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label>Referensi</label>
                        <select name="referensi_id" class="form-control">
                            <option value="">Pilih Referensi Gudang</option>
                            @foreach ($gudang as $item)
                                <option value="{{ $item->gudang_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Nama Rak</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Kapasitas</label>
                        <input type="text" class="form-control" id="kapasitas" name="kapasitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Barang</label>
                        <select name="barang_id[]" class="form-control js-example-basic-multiple" multiple>
                            <option value="">Pilih Referensi Barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}">{{ $item->nama }}</option>
                            @endforeach
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
      <form action="{{ url('rak/update') }}" method="post">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="tampildataRak"></div>
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
    function edit(id){
        $.ajax({ 
            type : 'get',
            url : "{{ url('rak/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildataRak').html(tampil);
                $('#editModal').modal('show');
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2();
                });
            } 
        })
    }
</script>

@endsection