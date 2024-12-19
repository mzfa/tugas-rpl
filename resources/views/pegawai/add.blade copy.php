@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
                <div class="breadcrumb-item">Tambah Pegawai</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Pegawai</h2>
            <form action="{{ url('pegawai/update') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Pegawai</h4>
                            </div>
                            <div class="card-body">
                                <div class="mt-4">
                                    <ul class="nav nav-pills row" style="width: 100%" id="myTab3" role="tablist">
                                        <li class="nav-item col-md-3 col-6 text-center">
                                            <a class="nav-link active " id="home-tab3" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">
                                            <i class="fas fa-user" style="font-size: 1.8em;margin: 10px;"></i> <br>
                                            1. Data Pribadi
                                            </a>
                                        </li>
                                        <li class="nav-item col-md-3 col-6 text-center">
                                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">
                                            <i class="fas fa-users" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            2. Keluarga
                                            </a>
                                        </li>
                                        <li class="nav-item col-md-3 col-6 text-center">
                                            <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">
                                            <i class="fas fa-school" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            3. Pendidikan
                                            </a>
                                        </li>
                                        <li class="nav-item col-md-3 col-6 text-center">
                                            <a class="nav-link " id="contact-tab4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">
                                            <i class="fas fa-paperclip" style="font-size: 1.8em;margin: 10px;"></i><br>
                                            4. Alamat & Kontak
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="myTabContent2">

                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="profile-tab3">
                                        <h1>Data Pribadi</h1>
                                        <form action="{{ url('pegawai/data_diri_store') }}" method="post" id="postForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Lengkap <em class="text-danger">*</em></label>
                                                        <input type="text" name="nama_lengkap" class="form-control required" placeholder="Nama Lengkap" id="nama_lengkap" required>
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
                                                        <input type="text" name="tempat_lahir" class="form-control required" placeholder="Tanggal Lahir" id="tempat_lahir" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tgl Lahir <em class="text-danger">*</em></label>
                                                        <input type="text" name="tgl_lahir" class="form-control datepicker required" placeholder="Tanggal Lahir" id="tgl_lahir" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Agama <em class="text-danger">*</em></label>
                                                        <input type="text" name="agama" class="form-control required" placeholder="Agama" id="agama" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin <em class="text-danger">*</em></label>
                                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control required">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Belum Menikah">Belum Menikah</option>
                                                            <option value="Sudah Menikah">Sudah Menikah</option>
                                                            <option value="Bercerai">Bercerai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Golongan Darah <em class="text-danger">*</em></label>
                                                        <select name="golongan_darah" id="golongan_darah" class="form-control required">
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
                                                        <label>Status Perkawinan <em class="text-danger">*</em></label>
                                                        <select name="status_perkawinan" id="status_perkawinan" class="form-control required">
                                                            <option value=""></option>
                                                            <option value="Belum Menikah">Belum Menikah</option>
                                                            <option value="Sudah Menikah">Sudah Menikah</option>
                                                            <option value="Bercerai">Bercerai</option>
                                                        </select>
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
                                                        <label>NPWP <em class="text-danger">*</em></label>
                                                        <input type="text" name="npwp" class="form-control required" placeholder="NPWP" id="npwp" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>STR</label>
                                                        <input type="text" name="str" class="form-control" placeholder="STR" id="str">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>SIP</label>
                                                        <input type="text" name="sip" class="form-control" placeholder="SIP" id="sip">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor BPJS Kesehatan</label>
                                                        <input type="text" name="nomor_bpjs_kesehatan" class="form-control" placeholder="Nomor BPJS Kesehatan" id="nomor_bpjs_kesehatan">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor BPJS Ketenagakerjaan</label>
                                                        <input type="text" name="nomor_bpjs_tk" class="form-control" placeholder="Nomor BPJS Ketenagakerjaan" id="nomor_bpjs_tk">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor MR (Medical Record)</label>
                                                        <input type="text" name="no_mr" class="form-control" placeholder="Nomor MR" id="no_mr">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat Email <em class="text-danger">*</em></label>
                                                        <input type="text" name="email" class="form-control required" placeholder="Email" id="email" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" id="savedata" class="btn btn-primary w-100 mb-2">Simpan</button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="home-tab3">
                                        <h1>Data Keluarga</h1>
                                        <div id="form-keluarga1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Status Keluarga</label>
                                                        <select name="status_keluarga" id="status_keluarga" class="form-control">
                                                            <option value="">Pilih</option>
                                                            <option value="Istri">Istri</option>
                                                            <option value="Anak">Anak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Lengkap</label>
                                                        <input type="text" name="nama_lengkap_kel" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" name="tempat_lahir_kel" class="form-control" placeholder="Tempat Lahir" id="tempat_lahir_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tgl Lahir</label>
                                                        <input type="text" name="tgl_lahir_kel" class="form-control datepicker" placeholder="Tanggal Lahir" id="tgl_lahir">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pendidikan Terkahir</label>
                                                        <input type="text" name="pendidikan_terakhir_kel" class="form-control" placeholder="Pendidikan Terkahir" id="pendidikan_terakhir_kel">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select name="jenis_kelamin_kel" id="jenis_kelamin" class="form-control">
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
                                                        <select name="golongan_darah_kel" id="golongan_darah_kel" class="form-control">
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
                                                        <input type="text" name="no_mr_kel" class="form-control" placeholder="Nomor MR" id="no_mr_kel">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tombolhapus1"></div>
                                            <hr class="text-primary">
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 mb-2" onclick="tambahkeluarga()">Tambah Keluarga</button>
                                        <input type="hidden" id="total_form_keluarga" value="1">
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab3">
                                        <h1>Data Pendidikan</h1>
                                        <div id="form-pendidikan1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Pendidikan</label>
                                                        <select name="jenis_pendidikan[]" id="jenis_pendidikan" class="form-control">
                                                            <option value="">Pilih</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Sekolah/Instansi</label>
                                                        <input type="text" name="nama_sekolah[]" class="form-control" placeholder="Nama Sekolah/Instansi" id="nama_sekolah">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tahun Lulus</label>
                                                        <input type="text" name="tahun_lulus[]" class="form-control" placeholder="Tahun Lulus" id="tahun_lulus">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jurusan/Fakultas</label>
                                                        <input type="text" name="jurusan[]" class="form-control" placeholder="Jurusan/Fakultas" id="jurusan">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <button type="button" id="hapuspendidikan1" class="btn btn-danger w-100 mb-2" onclick="hapuspendidikan()">Hapus</button> --}}
                                            <hr class="text-primary">
                                        </div>
                                        <button type="button" id="hapuspendidikan1" class="btn btn-danger w-100 mb-2" onclick="return hapuspendidikan()">Hapus</button>
                                        <button type="button" class="btn btn-primary w-100 mb-2" onclick="tambahpendidikan()">Tambah Pendidikan</button>
                                        <input type="hidden" id="total_form_pendidikan" value="1">
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="contact-tab4">
                                        <h1>Data Pendidikan</h1>
                                        <div id="form-pendidikan1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Telp Pribadi</label>
                                                        <input type="text" name="telp_pribadi" class="form-control" placeholder="No Telp Pribadi" id="telp_pribadi">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No Telp Keluarga</label>
                                                        <input type="text" name="telp_keluarga" class="form-control" placeholder="No Telp Keluarga" id="telp_keluarga">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Kontak Darurat</label>
                                                        <input type="text" name="nomor_kontak_darurat" class="form-control" placeholder="No Telp Pribadi" id="nomor_kontak_darurat">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No Telp Keluarga</label>
                                                        <input type="text" name="nomor_telp_keluarga" class="form-control" placeholder="No Telp Keluarga" id="nomor_telp_keluarga">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                            <h5>Alamat KTP</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat Lengkap</label>
                                                        <input type="text" name="alamat_ktp" class="form-control" placeholder="Alamat Lengkap" id="alamat_ktp">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <input type="text" name="provinsi_ktp" class="form-control" placeholder="Provinsi" id="provinsi_ktp">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kabupaten/Kota</label>
                                                        <input type="text" name="kota_ktp" class="form-control" placeholder="Kabupaten/Kota" id="kota_ktp">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kelurahan</label>
                                                        <input type="text" name="kelurahan_ktp" class="form-control" placeholder="Kelurahan" id="kelurahan_ktp">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-check-input" id="check_alamat" onclick="alamat_sama()" type="checkbox">
                                                        Alamat Sesuai KTP
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                            <h5>Alamat Tempat Tinggal</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat Lengkap</label>
                                                        <input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" id="alamat">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <input type="text" name="provinsi" class="form-control" placeholder="Provinsi" id="provinsi">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kabupaten/Kota</label>
                                                        <input type="text" name="kota" class="form-control" placeholder="Kabupaten/Kota" id="kota">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kelurahan</label>
                                                        <input type="text" name="kelurahan" class="form-control" placeholder="Kelurahan" id="kelurahan">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="text-primary">
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 mb-2" onclick="tambahpendidikan()">Tambah Pendidikan</button>
                                        <input type="hidden" id="total_form_pendidikan" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        /* Style the form */
        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            padding: 40px;
            width: 70%;
            min-width: 300px;
        }

        /* Style the input fields */
        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }
        select.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            /* height: 100%;
            width: 15px;
            margin: 0 2px; */
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#savedata').click(function (e) {
                e.preventDefault();
                if (n == 1 && !validateForm()) return false;

                $(this).html('Sending..');

            
                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ url('pegawai/biodata_diri') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log('ok')
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#savedata').html('Save Changes');
                    }
                });
            });
        });
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function tambahkeluarga(){
            let angka = parseInt(document.getElementById('total_form_keluarga').value);
            // Create a copy of it
            let variabel = '#form-keluarga'+angka;
            let tombol = '#tombolhapus'+angka;
            // console.log(variabel)
            var elem = document.querySelector(variabel);
            
            var clone = elem.cloneNode(true);
            
            let total = angka+1;
            // let tombolhapus = '<a type="button" class="btn btn-danger w-100" onclick="hapusform('+total+')">Hapus<a>';
            clone.append('<a type="button" class="btn btn-danger w-100" onclick="hapusform('+total+')">Hapus<a>');
            // Update the ID and add a class
            clone.id = 'form-keluarga'+total;
            elem.after(clone);
            // clone.classList.add('text-large');
            // console.log(elemtombol)
            // Inject it into the DOM
            document.getElementById('total_form_keluarga').value = total;

            // setTimeout(() => {
            //     document.getElementById(tombol).innerHTML = "asd";
            // }, 3000);
            
        }
        function alamat_sama(){
            if (document.getElementById('check_alamat').checked) {
                document.getElementById("alamat").disabled = true;
                document.getElementById("provinsi").disabled = true;
                document.getElementById("kota").disabled = true;
                document.getElementById("kelurahan").disabled = true;
            } else {
                document.getElementById("alamat").disabled = false;
                document.getElementById("provinsi").disabled = false;
                document.getElementById("kota").disabled = false;
                document.getElementById("kelurahan").disabled = false;
            }
        }
        function tambahpendidikan(){
            let angka = parseInt(document.getElementById('total_form_pendidikan').value);
            // Create a copy of it
            let variabel = '#form-pendidikan'+angka;
            var elem = document.querySelector(variabel);
            // var hapus = document.getElementById(hapus).innerHTML =
            
            var clone = elem.cloneNode(true);
            
            let total = angka+1;
            console.log(total)
            // Update the ID and add a class
            clone.id = 'form-pendidikan'+total;
            // clone.classList.add('text-large');
            
            // Inject it into the DOM
            elem.after(clone);
            // let tombol = '<a type="button" class="btn btn-danger w-100" onclick="hapusform('+total+')">Hapus<a>';
            // clone.append(tombol);
            document.getElementById('total_form_pendidikan').value = total;
        }

        function hapuspendidikan(){
            let angka = parseInt(document.getElementById('total_form_pendidikan').value);
            let variabel = '#form-pendidikan'+angka;
            var elem = document.querySelector(variabel);
            elem.remove();
            
            let total = angka-1;
            console.log(total)
            document.getElementById('total_form_pendidikan').value = total;
            return true;
        }

        // function showTab(n) {
        //     // This function will display the specified tab of the form ...
        //     var x = document.getElementsByClassName("tab");
        //     x[n].style.display = "block";
        //     // ... and fix the Previous/Next buttons:
        //     if (n == 0) {
        //         document.getElementById("prevBtn").style.display = "none";
        //     } else {
        //         document.getElementById("prevBtn").style.display = "inline";
        //     }
        //     if (n == (x.length - 1)) {
        //         document.getElementById("nextBtn").innerHTML = "Submit";
        //     } else {
        //         document.getElementById("nextBtn").innerHTML = "Next";
        //     }
        //     // ... and run a function that displays the correct step indicator:
        //     fixStepIndicator(n)
        // }

        // function nextPrev(n) {
        //     // This function will figure out which tab to display
        //     var x = document.getElementsByClassName("tab");
        //     // Exit the function if any field in the current tab is invalid:
        //     if (n == 1 && !validateForm()) return false;
        //     // Hide the current tab:
        //     x[currentTab].style.display = "none";
        //     // Increase or decrease the current tab by 1:
        //     currentTab = currentTab + n;
        //     // if you have reached the end of the form... :
        //     if (currentTab >= x.length) {
        //         //...the form gets submitted:
        //         document.getElementById("regForm").submit();
        //         return false;
        //     }
        //     // Otherwise, display the correct tab:
        //     showTab(currentTab);
        // }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByClassName("required");
            // console.log(w)
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // console.log(y[i].value)
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
                // console.log(y[i].value)
                if (y[i].value === "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            // if (valid) {
            //     document.getElementsByClassName("step")[currentTab].className += " finish";
                
            // }
            return valid; // return the valid status
        }

        // function fixStepIndicator(n) {
        //     // This function removes the "active" class of all steps...
        //     var i, x = document.getElementsByClassName("step");
        //     for (i = 0; i < x.length; i++) {
        //         x[i].className = x[i].className.replace(" active", "");
        //     }
        //     //... and adds the "active" class to the current step:
        //     x[n].className += " active";
        // }

        function data_diri(id) {
            $.ajax({
                type: 'post',
                url: "{{ url('pegawai/data_diri') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    
                }
            })
        }
    </script>
@endsection
