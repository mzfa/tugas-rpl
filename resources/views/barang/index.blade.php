@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Barang</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Barang</li>
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
                        <h4 class="card-title mb-0">Data Barang</h4>
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
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Kode Barang</th>
                                            <th>Satuan</th>
                                            <th>Lokasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="customer_name">
                                                    <a target="_blank" href="{{ url('gambar/barang/'.$item->gambar) }}">
                                                        <img src="{{ url('gambar/barang/'.$item->gambar) }}" alt="Kosong" width="50px">
                                                    </a>
                                                </td>
                                                <td class="customer_barang">{{ $item->nama }}</td>
                                                <td class="customer_name">{{ $item->kode_barang }}</td>
                                                <td class="customer_name">{{ $item->satuan }}</td>
                                                <td class="customer_name">{{ $item->lokasi }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                            <button class="btn btn-sm btn-success edit-item-btn" onclick="return edit({{ $item->barang_id }})">Edit</button>
                                                        </div>
                                                        <div class="remove">
                                                            <a class="btn btn-sm btn-danger remove-item-btn" onclick="return confirm('Apakah anda yakin ini dihapus?')" href="{{ url('barang/delete/' . $item->barang_id) }}">Remove</a>
                                                        </div>
                                                        <div class="detail">
                                                            <a class="btn btn-sm btn-warning detail-item-btn" href="{{ url('barang/detail/' . $item->barang_id) }}">Detail</a>
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
        <form action="{{ url('barang/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Kategori Barang</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option value=""></option>
                            <option value="Kategori A">Kategori A</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Satuan Barang</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Stok Minimal</label>
                        <input type="number" class="form-control" id="stok_minimal" name="stok_minimal" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Stok Maksimal</label>
                        <input type="number" class="form-control" id="stok_maksimal" name="stok_maksimal" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Lokasi</label>
                        <select name="lokasi" id="lokasi" class="form-control">
                            <option value=""></option>
                            <option value="Gudang A">Gudang A</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Gambar</label>
                        <div class="dropzone">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>

                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <!-- This is used as the file preview template -->
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-sm bg-light rounded">
                                                <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
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
      <form action="{{ url('barang/update') }}" method="post" enctype="multipart/form-data">
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
            url : "{{ url('barang/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildatabarang').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
</script>

@endsection