<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME_SCM') }}</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

    <link rel="apple-touch-icon" href="{{ asset(env('APP_LOGO_SCM')) }}" sizes="180x180">
  <link rel="icon" href="{{ asset(env('APP_LOGO_SCM')) }}" sizes="32x32" type="image/png">
  <link rel="icon" href="{{ asset(env('APP_LOGO_SCM')) }}" sizes="16x16" type="image/png">
  @yield('styles')
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
</head>

<body>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            
            @include('layouts.navbar')

            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    RS Umum Pekerja 2023
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>


    <div class="modal fade" id="buatPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="buatPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ url('buat_password') }}" method="post" >
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="staticBackdropLabel">INI PASSWORD UNTUK MELIHAT SLIP GAJI!!!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="password_detail" onkeyup="cekpassword()" name="password_detail" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-12 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-12">
                            <input type="text" class="form-control" id="password_detail_confirm" onkeyup="cekpassword()" name="password_detail_confirm" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" disabled id="ajaxPassword" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


  <!-- General JS Scripts -->
  <script src="{{ url('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ url('assets/modules/popper.js') }}"></script>
  <script src="{{ url('assets/modules/tooltip.js') }}"></script>
  <script src="{{ url('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ url('assets/modules/moment.min.js') }}"></script>
  <script src="{{ url('assets/js/stisla.js') }}"></script>
  
  <!-- JS Libraies -->
  <script src="{{ url('assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
  <script src="{{ url('assets/modules/chart.min.js') }}"></script>
  <script src="{{ url('assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
  <script src="{{ url('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ url('assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ url('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{ url('assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ url('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ url('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ url('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
  <script src="{{ url('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ url('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ url('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
  <script src="{{ url('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ url('assets/js/scripts.js') }}"></script>
  <script src="{{ url('assets/js/custom.js') }}"></script>
  

  <!-- Custom JS -->
  @if(Session('password_detail') == null && Auth::user()->id !== 0)
    <script>
        $(document).ready(function() {
            ubahpassword();
        });
        </script>
  @endif
  <script>
      function ubahpassword(){
          $('#buatPassword').modal('show');
      }
      
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });
        
    });
    function cekpassword(){
        let pass = $('#password_detail').val();
        let conf = $('#password_detail_confirm').val();
        // console.log(pass,conf);
        if(pass !== conf){
            $("#ajaxPassword").attr("disabled", true);
        }else{
            $("#ajaxPassword").attr("disabled", false);
        }
    }


    $("#table-1").dataTable({
        // dom: 'Bfrtip',
        // buttons: [
        //     'excel', 'pdf', 'print'
        // ]
    });
    // if(jQuery().select2) {
    //     $(".select2").select2();
    // }
  </script>

@yield('scripts')

@if (Session::has('success'))
<script>
    iziToast.success({
        title: 'Good!',
        message: "{{ Session::get('success') }}",
        position: 'topCenter' 
    });
</script>
@endif
@if (Session::has('error'))
<script>
    iziToast.warning({
        title: 'Error!',
        message: "{{ Session::get('error') }}",
        position: 'topCenter' 
    });
</script>
@endif
</body>
</html>