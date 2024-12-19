@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
                <div class="breadcrumb-item">Edit Pegawai</div>
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
                                <ul class="nav nav-pills row" style="width: 100%" id="myTab3" role="tablist">
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link active " id="home-tab3" data-toggle="tab" href="#tab1"
                                            role="tab" aria-controls="home" aria-selected="true">
                                            <i class="fas fa-user" style="font-size: 1.8em;margin: 10px;"></i> <br>
                                            1. Data Pribadi
                                        </a>
                                    </li>
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link " id="alamat-tab3" data-toggle="tab" href="#tab2"
                                            role="tab" aria-controls="tab4" aria-selected="false">
                                            <i class="fas fa-paperclip" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            2. Alamat & Kontak
                                        </a>
                                    </li>
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#tab3"
                                            role="tab" aria-controls="profile" aria-selected="false">
                                            <i class="fas fa-users" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            3. Keluarga
                                        </a>
                                    </li>
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#tab4"
                                            role="tab" aria-controls="contact" aria-selected="false">
                                            <i class="fas fa-school" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            4. Pendidikan
                                        </a>
                                    </li>
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#tab5"
                                            role="tab" aria-controls="contact" aria-selected="false">
                                            <i class="fas fa-briefcase" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            5. Riwayat Pekerjaan
                                        </a>
                                    </li>
                                    <li class="nav-item col-md-2 col-6 text-center">
                                        <a class="nav-link " id="alamat-tab3" data-toggle="tab" href="#tab6"
                                            role="tab" aria-controls="tab4" aria-selected="false">
                                            <i class="fas fa-certificate" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            6. Riwayat Pelatihan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent2">

                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="profile-tab3">
                                    <h4 class="mt-3">Data Pribadi</h4>
                                    <form action="{{ url('pegawai/update_data_diri') }}" method="post" id="postForm">
                                        @csrf
                                        <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Lengkap <em class="text-danger">*</em></label>
                                                    <input type="text" name="nama_pegawai" class="form-control required"
                                                        placeholder="Nama Lengkap" id="nama_pegawai" required
                                                        value="{{ $data->nama_pegawai }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gelar (opsional)</label>
                                                    <input type="text" name="gelar" class="form-control"
                                                        placeholder="Gelar" id="gelar" value="{{ $data->gelar }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tgl Masuk <em class="text-danger">*</em></label>
                                                    <input type="text" name="tanggal_masuk"
                                                        class="form-control datepicker required"
                                                        placeholder="Tanggal masuk" id="tanggal_masuk" required
                                                        value="{{ $data->tanggal_masuk }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir <em class="text-danger">*</em></label>
                                                    <input type="text" name="tempat_lahir" class="form-control required"
                                                        placeholder="Tempat Lahir" id="tempat_lahir" required
                                                        value="{{ $data->tempat_lahir }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tgl Lahir <em class="text-danger">*</em></label>
                                                    <input type="text" name="tanggal_lahir"
                                                        class="form-control datepicker required"
                                                        placeholder="Tanggal Lahir" onkeyup="hitungumur()" id="tanggal_lahir" required
                                                        value="{{ $data->tanggal_lahir }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Umur <em class="text-danger">*</em></label>
                                                    <input type="text" name="umur"
                                                        class="form-control" readonly placeholder="Umur "
                                                        id="yourage">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Agama <em class="text-danger">*</em></label>
                                                    <select name="agama" id="agama" class="form-control required">
                                                        <option value="">Pilih Agama</option>
                                                        <option @if ($data->agama == 'Islam') selected @endif
                                                            value="Islam">Islam</option>
                                                        <option @if ($data->agama == 'Kristen Protestan') selected @endif
                                                            value="Kristen Protestan">Kristen Protestan</option>
                                                        <option @if ($data->agama == 'Kristen Katolik') selected @endif
                                                            value="Kristen Katolik">Kristen Katolik</option>
                                                        <option @if ($data->agama == 'Hindu') selected @endif
                                                            value="Hindu">Hindu</option>
                                                        <option @if ($data->agama == 'Budha') selected @endif
                                                            value="Budha">Budha</option>
                                                        <option @if ($data->agama == 'Konghucu') selected @endif
                                                            value="Konghucu">Konghucu</option>
                                                        <option @if ($data->agama == 'Atheis') selected @endif
                                                            value="Atheis">Atheis</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin <em class="text-danger">*</em></label>
                                                    <select name="jk" id="jk" class="form-control required">
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option @if ($data->jk == 'Laki-Laki') selected @endif
                                                            value="Laki-Laki">Laki-Laki</option>
                                                        <option @if ($data->jk == 'Perempuan') selected @endif
                                                            value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Golongan Darah <em class="text-danger">*</em></label>
                                                    <select name="golongan_darah" id="golongan_darah"
                                                        class="form-control required">
                                                        <option value="">Pilih Golongan Darah</option>
                                                        <option @if ($data->golongan_darah == 'A') selected @endif
                                                            value="A">A</option>
                                                        <option @if ($data->golongan_darah == 'B') selected @endif
                                                            value="B">B</option>
                                                        <option @if ($data->golongan_darah == 'AB') selected @endif
                                                            value="AB">AB</option>
                                                        <option @if ($data->golongan_darah == 'O') selected @endif
                                                            value="O">O</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Perkawinan <em class="text-danger">*</em></label>
                                                    <select name="status_kawin" id="status_kawin"
                                                        class="form-control required">
                                                        <option value=""></option>
                                                        <option @if ($data->status_kawin == 'Belum Menikah') selected @endif
                                                            value="Belum Menikah">Belum Menikah</option>
                                                        <option @if ($data->status_kawin == 'Sudah Menikah') selected @endif
                                                            value="Sudah Menikah">Sudah Menikah</option>
                                                        <option @if ($data->status_kawin == 'Bercerai') selected @endif
                                                            value="Bercerai">Bercerai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIK <em class="text-danger">*</em></label>
                                                    <input type="number" name="nik" class="form-control required"
                                                        placeholder="NIK" id="nik" required
                                                        value="{{ $data->nik }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NPWP <em class="text-danger">*</em></label>
                                                    <input type="text" name="npwp" class="form-control required"
                                                        placeholder="NPWP" id="npwp" required
                                                        value="{{ $data->npwp }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>STR</label>
                                                    <input type="text" name="str" class="form-control"
                                                        placeholder="STR" id="str" value="{{ $data->str }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Terbit STR</label>
                                                    <input type="text" name="tanggal_terbit_str" class="form-control datepicker"
                                                        placeholder="Tanggal Terbit STR" id="tanggal_terbit_str" value="{{ $data->tanggal_terbit_str }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Masa Berlaku STR</label>
                                                    <input type="text" name="masa_berlaku_str" class="form-control datepicker"
                                                        placeholder="Masa Berlaku STR" id="masa_berlaku_str" value="{{ $data->masa_berlaku_str }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>SIP</label>
                                                    <input type="text" name="sip" class="form-control"
                                                        placeholder="SIP" id="sip" value="{{ $data->sip }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Terbit SIP</label>
                                                    <input type="text" name="tanggal_terbit_sip" class="form-control datepicker"
                                                        placeholder="Tanggal Terbit SIP" id="tanggal_terbit_sip" value="{{ $data->tanggal_terbit_sip }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Masa Berlaku SIP</label>
                                                    <input type="text" name="masa_berlaku_sip" class="form-control datepicker"
                                                        placeholder="Masa Berlaku SIP" id="masa_berlaku_sip" value="{{ $data->masa_berlaku_sip }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor BPJS Kesehatan</label>
                                                    <input type="text" name="no_bpjs_kes" class="form-control"
                                                        placeholder="Nomor BPJS Kesehatan" id="no_bpjs_kes"
                                                        value="{{ $data->no_bpjs_kes }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor BPJS Ketenagakerjaan</label>
                                                    <input type="text" name="no_bpjs_tk" class="form-control"
                                                        placeholder="Nomor BPJS Ketenagakerjaan" id="no_bpjs_tk"
                                                        value="{{ $data->no_bpjs_tk }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor MR (Medical Record)</label>
                                                    <input type="text" name="no_mr" class="form-control"
                                                        placeholder="Nomor MR" id="no_mr"
                                                        value="{{ $data->no_mr }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor Rekening BSI Pribadi <em class="text-danger">*</em></label>
                                                    <input type="text" name="no_rek_bsi" class="form-control required"
                                                        placeholder="Nomor Rekening BSI" id="no_rek_bsi"
                                                        value="{{ $data->no_rek_bsi }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pernah Terpapar Covid <em class="text-danger">*</em></label>
                                                    <select name="covid" id="covid" class="form-control required">
                                                        <option value="">Pilih</option>
                                                        <option @if ($data->covid == 'Ya') selected @endif
                                                            value="Ya">Ya</option>
                                                        <option @if ($data->covid == 'Tidak') selected @endif
                                                            value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat Email <em class="text-danger">*</em></label>
                                                    <input type="text" name="email" class="form-control required"
                                                        placeholder="Email" id="email" required
                                                        value="{{ $data->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Struktur</label>
                                                    <select name="struktur_id" id="struktur_id" class="form-control select2">
                                                        <option value="">Pilih Struktur</option>
                                                        @foreach($struktur as $item)
                                                        <option @if($data->struktur_id == $item->struktur_id) selected @endif
                                                            value="{{ $item->struktur_id }}">{{ $item->nama_struktur }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Grup Kepegawaian</label>
                                                    <select name="grup_kepegawaian_id" id="grup_kepegawaian_id" class="form-control select2">
                                                        <option value="">Pilih Grup Kepegawaian</option>
                                                        @foreach($grup_kepegawaian as $item)
                                                        <option @if($data->grup_kepegawaian_id == $item->grup_kepegawaian_id) selected @endif
                                                            value="{{ $item->grup_kepegawaian_id }}">{{ $item->nama_grup_kepegawaian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="savedata"
                                            class="btn btn-primary w-100 mb-2">Simpan</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="contact-tab4">
                                    <h1>Data Kontak & Alamat</h1>
                                    <div id="form-alamat">
                                        <form action="" method="post" id="formalamat">
                                            @csrf
                                            <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Telp Pribadi</label>
                                                        <input type="number" name="telp_pribadi" class="form-control required3"
                                                            placeholder="No Telp Pribadi" id="telp_pribadi"
                                                            value="{{ $data->telp_pribadi }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No Telp Keluarga</label>
                                                        <input type="number" name="telp_keluarga" class="form-control required3"
                                                            placeholder="No Telp Keluarga" id="telp_keluarga"
                                                            value="{{ $data->telp_keluarga }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Kontak Darurat</label>
                                                        <input type="number" name="nomor_kontak_darurat"
                                                            class="form-control required3" placeholder="No Kontak Darurat"
                                                            id="nomor_kontak_darurat"
                                                            value="{{ $data->nomor_kontak_darurat }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Kontak Darurat</label>
                                                        <input type="text" name="nama_kontak_darurat" class="form-control required3"
                                                            placeholder="Nama Kontak Darurat" id="nama_kontak_darurat"
                                                            value="{{ $data->nama_kontak_darurat }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Hubungan Dengan Kontak Darurat</label>
                                                        <select name="hubungan_kontak_darurat" id="hubungan_kontak_darurat" class="form-control">
                                                            <option @if ($data->hubungan_kontak_darurat == 'Orang Tua') selected @endif
                                                                value="Orang Tua">Orang Tua</option>
                                                            <option @if ($data->hubungan_kontak_darurat == 'Suami/Istri') selected @endif
                                                                value="Suami/Istri">Suami/Istri</option>
                                                            <option @if ($data->hubungan_kontak_darurat == 'Saudara') selected @endif
                                                                value="Saudara">Saudara</option>
                                                            <option @if ($data->hubungan_kontak_darurat == 'Lainnya') selected @endif
                                                                value="Lainnya">Lainnya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                            <h5>Alamat KTP</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat Lengkap</label>
                                                        <input type="text" name="alamat_ktp" class="form-control required3"
                                                            placeholder="Alamat Lengkap" id="alamat_ktp"
                                                            value="{{ $data->alamat_ktp }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <input type="text" name="provinsi_ktp" class="form-control required3"
                                                            placeholder="Provinsi" id="provinsi_ktp"
                                                            value="{{ $data->provinsi_ktp }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kabupaten/Kota</label>
                                                        <input type="text" name="kota_ktp" class="form-control required3"
                                                            placeholder="Kabupaten/Kota" id="kota_ktp"
                                                            value="{{ $data->kota_ktp }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kecamatan</label>
                                                        <input type="text" name="kecamatan_ktp" class="form-control required3"
                                                            placeholder="kecamatan" id="kecamatan_ktp"
                                                            value="{{ $data->kecamatan_ktp }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="check_alamat" onclick="return alamat_sama()" type="checkbox" id="check_alamat">
                                                        <label class="form-check-label" for="check_alamat" >Alamat Sesuai KTP</label>
                                                      </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                            <h5>Alamat Tempat Tinggal</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat Lengkap</label>
                                                        <input type="text" name="alamat" class="form-control"
                                                            placeholder="Alamat Lengkap" id="alamat"
                                                            value="{{ $data->alamat }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <input type="text" name="provinsi" class="form-control"
                                                            placeholder="Provinsi" id="provinsi"
                                                            value="{{ $data->provinsi }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kabupaten/Kota</label>
                                                        <input type="text" name="kota" class="form-control"
                                                            placeholder="Kabupaten/Kota" id="kota"
                                                            value="{{ $data->kota }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kecamatan</label>
                                                        <input type="text" name="kecamatan" class="form-control"
                                                            placeholder="kecamatan" id="kecamatan"
                                                            value="{{ $data->kecamatan }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                            <button type="button" id="savealamat" class="btn btn-primary w-100 mb-2">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="home-tab3">
                                    <h4 class="mt-3">Data Keluarga <a class="badge badge-primary text-white" onclick="$('#form-keluarga').show();">Tambah</a></h4>
                                    <div id="form-keluarga" style="display: none;">
                                        <form action="" method="POST" id="formkeluarga">
                                            @csrf
                                            <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Status Keluarga <em class="text-danger">*</em></label>
                                                        <select name="status_keluarga" id="status_keluarga"
                                                            class="form-control required1">
                                                            <option value="">Pilih</option>
                                                            <option value="Suami/Istri">Suami/Istri</option>
                                                            <option value="Anak">Anak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Lengkap <em class="text-danger">*</em></label>
                                                        <input type="text" name="nama_lengkap_kel"
                                                            class="form-control required1" placeholder="Nama Lengkap"
                                                            id="nama_lengkap_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir <em class="text-danger">*</em></label>
                                                        <input type="text" name="tempat_lahir_kel"
                                                            class="form-control required1" placeholder="Tempat Lahir"
                                                            id="tempat_lahir_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tgl Lahir <em class="text-danger">*</em></label>
                                                        <input type="text" name="tanggal_lahir_kel"
                                                            class="form-control datepicker required1" placeholder="Tanggal Lahir"
                                                            id="tgl_lahir">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pendidikan Terkahir</label>
                                                        <input type="text" name="pendidikan_terakhir_kel"
                                                            class="form-control" placeholder="Pendidikan Terkahir"
                                                            id="pendidikan_terakhir_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin <em class="text-danger">*</em></label>
                                                        <select name="jk_kel" id="jk_kel"
                                                            class="form-control required1">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Laki laki">Laki laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Golongan Darah <em class="text-danger">*</em></label>
                                                        <select name="golongan_darah_kel" id="golongan_darah_kel"
                                                            class="form-control required1">
                                                            <option value="">Pilih Golongan Darah</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="AB">AB</option>
                                                            <option value="O">O</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor MR</label>
                                                        <input type="text" name="no_mr_kel" class="form-control"
                                                            placeholder="Nomor MR" id="no_mr_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="reset" class="btn btn-danger w-100 mb-2"
                                                        onclick="$('#form-keluarga').hide();">Reset & Sembunyikan</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary w-100 mb-2"
                                                    id="savekeluarga">Tambah Keluarga</button>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                        </form>
                                    </div>
                                    <div id="table-keluarga"></div>
                                </div>
                                <div class="tab-pane fade" id="tab4" role="tabpanel"
                                    aria-labelledby="contact-tab3">
                                    <h4 class="mt-3">Data Pendidikan <a class="badge badge-primary text-white" onclick="$('#form-pendidikan').show();">Tambah</a></h4>
                                    <div id="form-pendidikan" style="display: none;">
                                        <form action="" method="POST" id="formpendidikan">
                                            @csrf
                                            <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Pendidikan</label>
                                                        <select name="jenis_pendidikan" id="jenis_pendidikan"
                                                            class="form-control required2">
                                                            <option value="">Pilih</option>
                                                            @foreach($jenis_pendidikan as $item)
                                                                <option value="{{ $item->jenis_pendidikan_id }}">{{ $item->nama_pendidikan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Sekolah/Instansi</label>
                                                        <input type="text" name="nama_sekolah" class="form-control required2"
                                                            placeholder="Nama Sekolah/Instansi" id="nama_sekolah">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lulus</label>
                                                        <input type="text" name="tanggal_lulus" class="form-control datepicker required2"
                                                            placeholder="tanggal Lulus" id="tanggal_lulus">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jurusan/Fakultas</label>
                                                        <input type="text" name="jurusan" class="form-control required2"
                                                            placeholder="Jurusan/Fakultas" id="jurusan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Ijazah</label>
                                                        <input type="text" name="nomor_ijazah" class="form-control required2"
                                                            placeholder="Nomor Ijazah" id="nomor_ijazah">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="reset" class="btn btn-danger w-100 mb-2"
                                                        onclick="$('#form-pendidikan').hide();">Reset & Sembunyikan</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary w-100 mb-2"
                                                    id="savependidikan">Tambah Pendidikan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="table-pendidikan"></div>
                                </div>
                                <div class="tab-pane fade" id="tab5" role="tabpanel"
                                    aria-labelledby="pekerjaan-tab3">
                                    <h4 class="mt-3">Data Pekerjaan <a class="badge badge-primary text-white" onclick="$('#form-pekerjaan').show();">Tambah</a></h4>
                                    <div id="form-pekerjaan" style="display: none;">
                                        <form action="" method="POST" id="formpekerjaan">
                                            @csrf
                                            <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Perusahaan/Instansi</label>
                                                        <input type="text" name="nama_perusahaan" class="form-control required5"
                                                            placeholder="Nama Perusahaan/Instansi" id="nama_perusahaan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bagian/Profesi</label>
                                                        <input type="text" name="bagian" class="form-control required5"
                                                            placeholder="Bagian/Profesi" id="bagian">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Masuk Bekerja</label>
                                                        <input type="text" name="tanggal_masuk_kerja" class="form-control required5 datepicker"
                                                            placeholder="Tanggal mulai Bekerja" id="tanggal_masuk_kerja">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Keluar Bekerja</label>
                                                        <input type="text" name="tanggal_keluar_kerja" class="form-control required5 datepicker"
                                                            placeholder="Tanggal Keluar Bekerja" id="tanggal_keluar_kerja">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="reset" class="btn btn-danger w-100 mb-2"
                                                        onclick="$('#form-pekerjaan').hide();">Reset & Sembunyikan</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary w-100 mb-2"
                                                    id="savepekerjaan">Tambah pekerjaan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="table-pekerjaan"></div>
                                </div>
                                <div class="tab-pane fade" id="tab6" role="tabpanel"
                                    aria-labelledby="pelatihan-tab3">
                                    <h4 class="mt-3">Data Pelatihan <a class="badge badge-primary text-white" onclick="$('#form-pelatihan').show();">Tambah</a></h4>
                                    <div id="form-pelatihan" style="display: none;">
                                        <form action="" method="POST" id="formpelatihan" enctype="multipart/form-data">
                                            <input type="hidden" name="pegawai_id"
                                            value="{{ Crypt::encrypt($data->pegawai_id) }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Pelatihan</label>
                                                        <select name="jenis_pelatihan" id="jenis_pelatihan"
                                                            class="form-control required6">
                                                            <option value="">Pilih</option>
                                                            @foreach($jenis_pelatihan as $item)
                                                                <option value="{{ $item->jenis_pelatihan_id }}">{{ $item->nama_jenis_pelatihan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Pelatihan</label>
                                                        <input type="text" name="nama_pelatihan" class="form-control required6"
                                                            placeholder="Nama Pelatihan" id="nama_pelatihan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Pelatihan</label>
                                                        <input type="text" name="tanggal_pelatihan" class="form-control datepicker required6"
                                                            placeholder="Tanggal Pelatihan" id="tanggal_pelatihan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Penyelenggara</label>
                                                        <input type="text" name="penyelenggara" class="form-control required6"
                                                        placeholder="Penyelenggara" id="penyelenggara">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jumlah Jam Pelajaran</label>
                                                        <input type="text" name="jam_pelajaran" class="form-control required6"
                                                        placeholder="Jumlah Jam Pelajaran" id="jam_pelajaran">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bukti Pelatihan</label>
                                                        <input type="file" name="bukti_pelatihan" class="form-control required6"
                                                            placeholder="Bukti Pelatihan" id="bukti_pelatihan">
                                                    </div>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="reset" class="btn btn-danger w-100 mb-2"
                                                        onclick="$('#form-pelatihan').hide();">Reset & Sembunyikan</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary w-100 mb-2"
                                                    id="savepelatihan">Tambah Pelatihan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="table-pelatihan"></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('styles')
    <style>
        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd !important;
        }

        select.invalid {
            background-color: #ffdddd !important;
        }

        .is-invalid .select2-selection,
        .needs-validation~span>.select2-dropdown {
            border-color: red !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(function() {

            tablePendidikan('{{ Crypt::encrypt($data->pegawai_id) }}')
            tableKeluarga('{{ Crypt::encrypt($data->pegawai_id) }}')
            tablePelatihan('{{ Crypt::encrypt($data->pegawai_id) }}')
            tableRiwayatPekerjaan('{{ Crypt::encrypt($data->pegawai_id) }}')

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }

                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ url('pegawai/update_data_diri') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savedata').html('Simpan');
                        $('#alamat-tab3').trigger('click');
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savedata').html('Simpan');
                    }
                });
            });
            $('#savekeluarga').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm1()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }
                $.ajax({
                    data: $('#formkeluarga').serialize(),
                    url: "{{ url('pegawai/tambah_keluarga') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savekeluarga').html('Simpan');
                        $('#formkeluarga').trigger("reset");
                        $('#form-keluarga').hide();
                        tableKeluarga('{{ Crypt::encrypt($data->pegawai_id) }}')
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savekeluarga').html('Simpan');
                    }
                });
            });
            $('#savealamat').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm3()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }
                $.ajax({
                    data: $('#formalamat').serialize(),
                    url: "{{ url('pegawai/update_alamat') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savealamat').html('Simpan');
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savealamat').html('Simpan');
                    }
                });
            });
            $('#savependidikan').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm2()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }
                $.ajax({
                    data: $('#formpendidikan').serialize(),
                    url: "{{ url('pegawai/tambah_pendidikan') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savependidikan').html('Simpan');
                        $('#formpendidikan').trigger("reset");
                        tablePendidikan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savependidikan').html('Simpan');
                    }
                });
            });
            $('#savepekerjaan').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm5()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }


                $.ajax({
                    data: $('#formpekerjaan').serialize(),
                    url: "{{ url('pegawai/tambah_pekerjaan') }}",
                    type: "POST",
                    dataType: 'json',
                    // dataType: 'json',
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savepekerjaan').html('Simpan');
                        $('#formpekerjaan').trigger("reset");
                        $('#form-pekerjaan').hide();
                        tableRiwayatPekerjaan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savepekerjaan').html('Simpan');
                    }
                });
            });
            $('#savepelatihan').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan..');
                if (!validateForm6()) {
                    iziToast.warning({
                        title: 'Opps!',
                        message: 'Periksa kembali isian anda',
                        position: 'bottomCenter'
                    });
                    $(this).html('Simpan');
                    return false;
                }

                var form = $('#formpelatihan')[0];
                var data = new FormData(form);
                jQuery.each(jQuery('#bukti_pelatihan')[0].files, function(i, file) {
                    data.append('file-'+i, file);
                });
                console.log(data);

                $.ajax({
                    // data: $('#formpelatihan').serialize(),
                    data: data,
                    url: "{{ url('pegawai/tambah_pelatihan') }}"+'?_token=' + '{{ csrf_token() }}',
                    type: "POST",
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    timeout: 600000,
                    success: function(data) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Simpan',
                            position: 'bottomCenter'
                        });
                        $('#savepelatihan').html('Simpan');
                        $('#formpelatihan').trigger("reset");
                        $('#form-pelatihan').hide();
                        tablePelatihan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    },
                    error: function(data) {
                        iziToast.warning({
                            title: 'Opps!',
                            message: 'Data Gagal Disimpan',
                            position: 'bottomCenter'
                        });
                        $('#savepelatihan').html('Simpan');
                    }
                });
            });
        });

        function validateForm() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }
        function validateForm1() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required1");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }
        function validateForm2() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required2");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }
        function validateForm3() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required3");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }
        function validateForm5() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required5");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }
        function validateForm6() {
            var y, i, valid = true;
            y = document.getElementsByClassName("required6");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid; 
        }

        function hapuskeluarga(id) {
            if(confirm('Apakah anda yakin ingin di hapus?')){
                $.ajax({
                    type: 'get',
                    url: "{{ url('pegawai/hapus_keluarga') }}/" + id,
                    // data:{'id':id}, 
                    success: function(tampil) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Hapus',
                            position: 'bottomCenter'
                        });
                        tableKeluarga('{{ Crypt::encrypt($data->pegawai_id) }}')
                    }
                })
            }
        }
        function hapuspendidikan(id) {
            if(confirm('Apakah anda yakin ingin di hapus?')){
                $.ajax({
                    type: 'get',
                    url: "{{ url('pegawai/hapus_pendidikan') }}/" + id,
                    // data:{'id':id}, 
                    success: function(tampil) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Hapus',
                            position: 'bottomCenter'
                        });
                        tablePendidikan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    }
                })
            }
        }
        function hapuspekerjaan(id) {
            if(confirm('Apakah anda yakin ingin di hapus?')){
                $.ajax({
                    type: 'get',
                    url: "{{ url('pegawai/hapus_pekerjaan') }}/" + id,
                    // data:{'id':id}, 
                    success: function(tampil) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Hapus',
                            position: 'bottomCenter'
                        });
                        tableRiwayatPekerjaan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    }
                })
            }
        }
        function hapuspelatihan(id) {
            if(confirm('Apakah anda yakin ingin di hapus?')){
                $.ajax({
                    type: 'get',
                    url: "{{ url('pegawai/hapus_pelatihan') }}/" + id,
                    // data:{'id':id}, 
                    success: function(tampil) {
                        iziToast.success({
                            title: 'Selamat',
                            message: 'Data Berhasil Di Hapus',
                            position: 'bottomCenter'
                        });
                        tablePelatihan('{{ Crypt::encrypt($data->pegawai_id) }}')
                    }
                })
            }
        }

        function tablePendidikan(id){
            $.ajax({
                type: 'get',
                url: "{{ url('pegawai/table_pendidikan') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    // console.log(tampil)
                    $('#table-pendidikan').html(tampil);
                }
            })
        }
        function tableKeluarga(id){
            $.ajax({
                type: 'get',
                url: "{{ url('pegawai/table_keluarga') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#table-keluarga').html(tampil);
                }
            })
        }
        function tableRiwayatPekerjaan(id){
            $.ajax({
                type: 'get',
                url: "{{ url('pegawai/table_riwayat_pekerjaan') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#table-pekerjaan').html(tampil);
                }
            })
        }
        function tablePelatihan(id){
            $.ajax({
                type: 'get',
                url: "{{ url('pegawai/table_pelatihan') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#table-pelatihan').html(tampil);
                }
            })
        }
        
        function alamat_sama(){
            if (document.getElementById('check_alamat').checked) {
                document.getElementById("alamat").disabled = true;
                document.getElementById("provinsi").disabled = true;
                document.getElementById("kota").disabled = true;
                document.getElementById("kecamatan").disabled = true;
            } else {
                document.getElementById("alamat").disabled = false;
                document.getElementById("provinsi").disabled = false;
                document.getElementById("kota").disabled = false;
                document.getElementById("kecamatan").disabled = false;
            }
        }
        hitungumur();
        function hitungumur(){
            var tgl1=new Date(document.getElementById("tanggal_lahir").value);
            var tgl2=new Date(); 
            var timeDiff = Math.abs(tgl2.getTime() - tgl1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            document.getElementById("yourage").value = Math.round(diffDays/365) + " Tahun";
        }

        if(jQuery().select2) {
            $(".select2").select2();
        }
    </script>
@endsection
