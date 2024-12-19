@extends('layouts.app')

@section('content')
@php
    $indent = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
@endphp
<section class="section">
    <div class="section-header">
        <h1>Profesi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
            <div class="breadcrumb-item">Profesi</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Profesi</h2>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profesi</h4>
                        <div class="col-auto">
                            <a tooltip="Sync Data Profesi" href="{{ url('profesi/sync') }}" id="create_record" class="btn btn-danger text-white shadow-sm">
                                <i class="bi bi-sync"></i> Sync
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Nama Profesi</th>
                                        <th>Group </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $profesi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $profesi->nama_profesi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection