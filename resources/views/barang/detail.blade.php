@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Stok Barang</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Stok Barang</li>
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
                        <h4 class="card-title mb-0">Data Stok Barang</h4>
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
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nomor Batch</th>
                                            <th>Lokasi</th>
                                            <th>Jumlah Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($stok_real as $item)
                                            <tr>
                                                <td class="customer_barang">{{ $item->batch }}</td>
                                                <td class="customer_name">{{ $item->nama }}</td>
                                                <td class="customer_name">{{ $item->jumlah_barang }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                            <button class="btn btn-sm btn-success edit-item-btn" onclick="return edit({{ $item->stock_real_id }})">Edit</button>
                                                        </div>
                                                        <div class="remove">
                                                            <a class="btn btn-sm btn-danger remove-item-btn" onclick="return confirm('Apakah anda yakin ini dihapus?')" href="{{ url('barang/stok_depo/delete/' . $item->stock_real_id) }}">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
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
        <form action="{{ url('barang/stok_depo/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="{{ $data->barang_id }}" class="form-control" id="barang_id" name="barang_id" required>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Batch</label>
                        <input type="text" class="form-control" id="batch" name="batch" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Lokasi Rak</label>
                        <select name="rak_id" id="rak_id" class="form-control" required>
                            <option value=""></option>
                            @foreach ($rak as $item2)
                                <option value="{{ $item2->rak_id ?? null }}">{{ $item2->nama ?? null }}</option>
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
      <form action="{{ url('barang/stok_depo/update') }}" method="post" enctype="multipart/form-data">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="tampildatabarang"></div>
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
            url : "{{ url('barang/stok_depo/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildatabarang').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
</script>

@endsection