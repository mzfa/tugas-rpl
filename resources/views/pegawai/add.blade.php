@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
                <div class="breadcrumb-item">Tambah Pegawai</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Pegawai</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Pegawai</h4>
                        </div>
                        <div class="card-body">
                            <div class="mt-4">
                                <h1>Data Pribadi</h1>
                                <form action="{{ url('pegawai/store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap <em class="text-danger">*</em></label>
                                                <input type="text" name="nama_pegawai" class="form-control required" placeholder="Nama Lengkap" id="nama_pegawai" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gelar (opsional)</label>
                                                <input type="text" name="gelar" class="form-control" placeholder="Gelar" id="gelar">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Lahir <em class="text-danger">*</em></label>
                                                <input type="text" name="tempat_lahir" class="form-control required" placeholder="Tempat Lahir" id="tempat_lahir" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tgl Lahir <em class="text-danger">*</em></label>
                                                <input type="text" name="tanggal_lahir" class="form-control datepicker required" placeholder="Tanggal Lahir" id="tanggal_lahir" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Masuk <em class="text-danger">*</em></label>
                                                <input type="text" name="tanggal_masuk" class="form-control datepicker required" placeholder="Tanggal Lahir" id="tanggal_masuk" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIK <em class="text-danger">*</em></label>
                                                <input type="number" name="nik" class="form-control required" placeholder="NIK" id="nik" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat Email <em class="text-danger">*</em></label>
                                                <input type="text" name="email" class="form-control required" placeholder="Email" id="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bagian <em class="text-danger">*</em></label>
                                                <select name="bagian_id" id="bagian_id" class="form-control required select2" required>
                                                    <option value="">Pilih Bagian</option>
                                                    @foreach($bagian as $item)
                                                    <option value="{{ $item->bagian_id }}">{{ $item->nama_bagian }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profesi <em class="text-danger">*</em></label>
                                                <select name="profesi_id" id="profesi_id" class="form-control required select2" required>
                                                    <option value="">Pilih Profesi</option>
                                                    @foreach($profesi as $item)
                                                    <option value="{{ $item->profesi_id }}">{{ $item->nama_profesi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Struktur </label>
                                                <select name="struktur_id" id="struktur_id" class="form-control select2">
                                                    <option value="">Pilih Struktur</option>
                                                    @foreach($struktur as $item)
                                                    <option value="{{ $item->struktur_id }}">{{ $item->nama_struktur }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mb-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

