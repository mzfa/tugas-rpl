@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Penerimaan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Penerimaan</li>
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
                        <h4 class="card-title mb-0">Data Penerimaan</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="display table table-bordered dataTable no-footer" id="buttons-datatables">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="customer_nama">Tanggal Pemesanan</th>
                                            <th class="sort" data-sort="customer_nama">Kode</th>
                                            <th class="sort" data-sort="customer_nama">Purchasing Document</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $spacing = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  
                                        @endphp
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->tanggal }}</td>
                                                <td>{{ $item->kode }}</td>
                                                <td>{{ $item->purchasing_document }}</td>
                                                <td>
                                                    @if ($item->flag_selesai != 1)
                                                        <button onclick="detail('{{ $item->pemesanan_id }}')" class="btn btn-warning"> Terima Barang</button>
                                                        @if (!empty($item->faktur))
                                                            <a target="_blank" href="{{ url('penerimaan/lihat/'.$item->pemesanan_id) }}" class="btn btn-primary text-white">Konfirmasi Penyimpanan</a>
                                                        @endif
                                                    @else
                                                        {{-- <span class="badge bg-primary">Barang Sudah di terima semua</span> --}}
                                                        <a target="_blank" href="{{ url('penerimaan/lihat/'.$item->pemesanan_id) }}" class="btn btn-primary text-white">Konfirmasi Penyimpanan</a>
                                                    @endif
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
        <form action="{{ url('penerimaan/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Tanggal Penerimaan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value=""></option>
                            @foreach ($supplier as $item)
                                <option value="{{ $item->supplier_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control"></textarea>
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
      <form action="{{ url('penerimaan/update') }}" method="post">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="tampildatapenerimaan"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
          </div>
      </form>
    </div>
</div>
<div class="modal modal-xl fade" id="detailModal" tabindex="-1"> 
    <div class="modal-dialog">
      <form action="{{ url('penerimaan/update_detail') }}" method="post">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Detail Penerimaan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div id="tampildetailpenerimaan"></div>
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
            url : "{{ url('penerimaan/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildatapenerimaan').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
    function detail(id){
        $.ajax({ 
            type : 'get',
            url : "{{ url('penerimaan/detail')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildetailpenerimaan').html(tampil);
                $('#detailModal').modal('show');
            } 
        })
    }
</script>

@endsection