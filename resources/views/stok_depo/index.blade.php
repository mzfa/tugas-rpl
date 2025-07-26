@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Stok Depo</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Stok Depo</li>
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
                        <h4 class="card-title mb-0">Data Stok Depo</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            
                            <div class="table-responsive">
                                <table class="display table table-bordered dataTable no-footer" id="buttons-datatables">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="sort" data-sort="customer_nama">Nama Barang</th>
                                        <th class="sort" data-sort="customer_nama">Jumlah Barang</th>
                                        <th class="sort" data-sort="customer_nama">Nomor Batch</th>
                                        <th class="sort" data-sort="customer_nama">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->jumlah_barang }}</td>
                                            <td>{{ $item->batch }}</td>
                                            <td>{{ $item->nama_gudang. ' | '. $item->nama_rak }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@endsection

