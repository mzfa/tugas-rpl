@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Bagian</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Bagian</li>
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
                        <h4 class="card-title mb-0">Data Bagian</h4>
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
                                            <th class="sort" data-sort="customer_nama">Nama Bagian</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $spacing = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  
                                        @endphp
                                        @foreach ($data_bagian as $item)
                                            <tr>
                                                <td>{{ $item['nama_bagian'] }}</td>
                                                <td>
                                                    <button onclick="edit('{{ $item['bagian_id'] }}')" class="btn btn-primary"> Edit</button>
                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item['bagian_id'] }}')"
                                                            class="btn btn-danger text-white">Hapus</a>
                                                </td>
                                            </tr>
                                            @foreach ($item['sub_bagian'] as $item1)
                                                <tr>
                                                    <td>{!! $spacing !!}{{ $item1['nama_bagian'] }}</td>
                                                    <td>
                                                        <button onclick="edit('{{ $item1['bagian_id'] }}')" class="btn btn-primary"> Edit</button>
                                                        <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item1['bagian_id'] }}')"
                                                                class="btn btn-danger text-white">Hapus</a>
                                                    </td>
                                                </tr>
                                                @foreach ($item1['sub_bagian'] as $item2)
                                                    <tr>
                                                        <td>{!! $spacing. $spacing !!}{{ $item2['nama_bagian'] }}</td>
                                                        <td>
                                                            <button onclick="edit('{{ $item2['bagian_id'] }}')" class="btn btn-primary"> Edit</button>
                                                            <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item2['bagian_id'] }}')"
                                                                    class="btn btn-danger text-white">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    @foreach ($item2['sub_bagian'] as $item3)
                                                        <tr>
                                                            <td>{!!  $spacing. $spacing. $spacing !!}{{ $item3['nama_bagian'] }}</td>
                                                            <td>
                                                                <button onclick="edit('{{ $item3['bagian_id'] }}')" class="btn btn-primary"> Edit</button>
                                                                <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item3['bagian_id'] }}')"
                                                                        class="btn btn-danger text-white">Hapus</a>
                                                            </td>
                                                        </tr>
                                                        @foreach ($item3['sub_bagian'] as $item4)
                                                            <tr>
                                                                <td>{!!  $spacing. $spacing. $spacing.$spacing !!}{{ $item4['nama_bagian'] }}</td>
                                                                <td>
                                                                    <button onclick="edit('{{ $item4['bagian_id'] }}')" class="btn btn-primary"> Edit</button>
                                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item4['bagian_id'] }}')"
                                                                            class="btn btn-danger text-white">Hapus</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
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
        <form action="{{ url('bagian/store') }}" method="post" enctype="multipart/form-data">
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
                            <option value="">Pilih Referensi Bagian</option>
                            @foreach ($bagian as $item)
                                <option value="{{ $item->bagian_id }}">{{ $item->nama_bagian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Nama Bagian</label>
                        <input type="text" class="form-control" id="nama_bagian" name="nama_bagian" required>
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
      <form action="{{ url('bagian/update') }}" method="post">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="tampildatabagian"></div>
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
            url : "{{ url('bagian/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildatabagian').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
</script>

@endsection