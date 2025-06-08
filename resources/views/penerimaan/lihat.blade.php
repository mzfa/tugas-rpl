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
                                    <div class="mb-3">
                                        <label for="staticEmail" class="form-label">Tanggal Penerimaan</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $penerimaan->tanggal ?? '' }}" {{ $disable }} required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="staticEmail" class="form-label">No Surat Jalan/Dokumen Referensi</label>
                                        <input type="text" class="form-control" id="faktur" name="faktur" value="{{ $penerimaan->faktur ?? '' }}" {{ $disable }} required>
                                    </div>
                                    <input class="form-check-input" type="checkbox" name="flag_selesai" value="1" @if(!empty($penerimaan->flag_selesai)) checked @endif> Penerimaan Selesai
                                    <table class="table align-middle table-nowrap mt-3" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="customer_nama">Nama Barang</th>
                                                <th class="sort" data-sort="customer_nama">Kode Barang</th>
                                                <th class="sort" data-sort="customer_nama">Satuan</th>
                                                <th class="sort" data-sort="customer_nama">Pesan</th>
                                                <th class="sort" data-sort="customer_nama">Terima</th>
                                                <th class="sort" data-sort="customer_nama">Batch</th>
                                                <th class="sort" data-sort="customer_nama">Exp</th>
                                                <th class="sort" data-sort="customer_nama">Rak</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" @if(in_array($item->barang_id,$pemesanan_detail)) checked @endif name="barang_id[]" value="{{ $item->barang_id }}">
                                                        </div>
                                                    </th>
                                                    <td class="customer_name">{{ $item->nama }}</td>
                                                    <td class="customer_name">{{ $item->kode_barang }}</td>
                                                    <td class="customer_name">{{ $item->satuan }}</td>
                                                    <td class="customer_name">{{ $jumlah[$item->barang_id] ?? '' }}</td>
                                                    <td class="customer_name">{{ $item->terima ?? '' }}</td>
                                                    <td class="customer_name">{{ $item->batch ?? '' }}</td>
                                                    <td><input type="date" class="form-control" {{ $disable }} name="expired[{{ $item->barang_id }}]" value="{{ $item->expired ?? '' }}"></td>
                                                    <td>
                                                        <select {{ $disable }} name="rak_id[{{ $item->barang_id }}]" class="form-control">
                                                            <option value="">Pilih Rak</option>
                                                            @foreach ($rak as $item2)
                                                                <option @if($item->rak_id == $item2->rak_id) selected @endif value="{{ $item2->rak_id }}">{{ $item2->nama }}</option>
                                                            @endforeach
                                                        </select>
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
        
        <input type="hidden" name="pemesanan_id" value="{{ $id }}">
    </div>
</div>
@endsection
