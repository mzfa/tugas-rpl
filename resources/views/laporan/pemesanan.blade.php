@extends('layouts.app')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Laporan Pemesanan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                            <li class="breadcrumb-item active">Pemesanan</li>
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
                        <h4 class="card-title mb-0">Laporan Pemesanan</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-bordered dataTable no-footer" id="buttons-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nomor PO</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="customer_name">{{ $item->kode_pemesanan }}</td>
                                            <td class="customer_name">{{ $item->tanggal_pemesanan }}</td>
                                            <td class="customer_name">{{ $item->nama_supplier }}</td>
                                            <td class="customer_name">{{ (!empty($item->flag_selesai)) ? "Barang Sudah Diterima" : "-" }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@endsection

