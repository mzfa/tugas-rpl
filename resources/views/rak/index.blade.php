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
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box ms-2">
                                            <input type="text" class="form-control search" placeholder="Search...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_nama">Nama Gudang</th>
                                            <th class="sort" data-sort="customer_nama">Nama Rak</th>
                                            <th class="sort" data-sort="customer_nama">Kapasitas</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        {{-- @php
                                            $spacing = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  
                                        @endphp
                                        @foreach ($data_rak as $item)
                                            <tr>
                                                <td>{{ $item['nama'] }}</td>
                                                <td>
                                                    <button onclick="edit('{{ $item['rak_id'] }}')" class="btn btn-primary"> Edit</button>
                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item['rak_id'] }}')"
                                                            class="btn btn-danger text-white">Hapus</a>
                                                </td>
                                            </tr>
                                            @foreach ($item['sub_rak'] as $item1)
                                                <tr>
                                                    <td>{!! $spacing !!}{{ $item1['nama'] }}</td>
                                                    <td>
                                                        <button onclick="edit('{{ $item1['rak_id'] }}')" class="btn btn-primary"> Edit</button>
                                                        <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item1['rak_id'] }}')"
                                                                class="btn btn-danger text-white">Hapus</a>
                                                    </td>
                                                </tr>
                                                @foreach ($item1['sub_rak'] as $item2)
                                                    <tr>
                                                        <td>{!! $spacing. $spacing !!}{{ $item2['nama'] }}</td>
                                                        <td>
                                                            <button onclick="edit('{{ $item2['rak_id'] }}')" class="btn btn-primary"> Edit</button>
                                                            <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item2['rak_id'] }}')"
                                                                    class="btn btn-danger text-white">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    @foreach ($item2['sub_rak'] as $item3)
                                                        <tr>
                                                            <td>{!!  $spacing. $spacing. $spacing !!}{{ $item3['nama'] }}</td>
                                                            <td>
                                                                <button onclick="edit('{{ $item3['rak_id'] }}')" class="btn btn-primary"> Edit</button>
                                                                <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item3['rak_id'] }}')"
                                                                        class="btn btn-danger text-white">Hapus</a>
                                                            </td>
                                                        </tr>
                                                        @foreach ($item3['sub_rak'] as $item4)
                                                            <tr>
                                                                <td>{!!  $spacing. $spacing. $spacing.$spacing !!}{{ $item4['nama'] }}</td>
                                                                <td>
                                                                    <button onclick="edit('{{ $item4['rak_id'] }}')" class="btn btn-primary"> Edit</button>
                                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','rak/delete/{{ $item4['rak_id'] }}')"
                                                                            class="btn btn-danger text-white">Hapus</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach --}}
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
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                        Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="javascript:void(0);">
                                        Next
                                    </a>
                                </div>
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