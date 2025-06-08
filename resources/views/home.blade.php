@extends('layouts.app')

@section('content')


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Home</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-5">
                    <div class="d-flex flex-column h-100">
                        <div class="row h-100">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-0">

                                        <div class="row align-items-end">
                                            <div class="col-sm-8">
                                                <div class="p-3">
                                                    <p class="fs-16 lh-base">Selamat Datang {{ Auth::user()->name }} <span
                                                            class="fw-semibold">Semoga Harimu Menyenangkan</span><i
                                                            class="mdi mdi-arrow-right"></i></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="px-3">
                                                    <img src="{{ asset('assets/images/user-illustarator-2.png" class="img-fluid') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->

                    </div>
                </div> <!-- end col-->

            </div> <!-- end row-->

        </div>
        <!-- container-fluid -->
    </div>
@endsection
