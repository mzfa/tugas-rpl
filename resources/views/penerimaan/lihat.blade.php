@extends('layouts.app')

@section('content')

@php
    if(!empty($penerimaan->flag_selesai)){
        $disable = 'readonly';
    }else{
        $disable = '';
    } 
@endphp
<div class="page-content">
    <div class="container-fluid">
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

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mt-3" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="customer_nama">Nama Barang</th>
                                                <th class="sort" data-sort="customer_nama">Kode Barang</th>
                                                <th class="sort" data-sort="customer_nama">Satuan</th>
                                                <th class="sort" data-sort="customer_nama">Pesan</th>
                                                <th class="sort" data-sort="customer_nama">Terima</th>
                                                <th class="sort" data-sort="customer_nama">Batch</th>
                                                {{-- <th class="sort" data-sort="customer_nama">Exp</th> --}}
                                                <th class="sort" data-sort="customer_nama">Rak</th>
                                                <th class="sort" data-sort="customer_nama">Scan Rak</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="customer_name">{{ $item->nama }}</td>
                                                    <td class="customer_name">{{ $item->kode_barang }}</td>
                                                    <td class="customer_name">{{ $item->satuan }}</td>
                                                    <td class="customer_name">{{ $jumlah[$item->barang_id] ?? '' }}</td>
                                                    <td class="customer_name">{{ $item->terima ?? '' }}</td>
                                                    <td class="customer_name">{{ $item->batch ?? '' }}</td>
                                                    {{-- <td>{{ $item->expired ?? '' }}</td> --}}
                                                    <td>{{ $item->nama_rak }}</td>
                                                    <td>
                                                        <a target="_blank" href="{{ url('penerimaan/scan/'.$item->penerimaan_detail_id) }}" class="btn btn-primary text-white">Scan</a>
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
</div>
@endsection
