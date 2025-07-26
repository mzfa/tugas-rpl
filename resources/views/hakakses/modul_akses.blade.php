@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Listjs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Listjs</li>
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
                            <h4 class="card-title mb-0">Add, Edit & Remove</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="table-responsive table-card mb-1">
                                    <form action="{{ url('hakakses/modul_akses') }}" method="post">
                                        @csrf
                                        <button type="submit" action="{{ url('menu') }}"
                                            class="btn btn-primary w-100 m-3">Simpan
                                            Akses</button><br>
                                        <input type="hidden" name="hakakses_id"
                                            value="{{ $data_hakakses[0]->hakakses_id }}">
                                        <table class="table mt-2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Menu</th>
                                                    <th>Url</th>
                                                </tr>
                                            </thead>
                                            <tbody class="form-check-all">
                                                @php $menu_akses = explode ("|", $data_hakakses[0]->menu_id) @endphp
                                                @foreach ($menu as $item)
                                                    <tr class="bg-info">
                                                        <td>
                                                            <?php
                                                            $status = null;
                                                            foreach ($menu_akses as $cekmenu) {
                                                                if ($cekmenu == $item['menu_id']) {
                                                                    $status = 'active';
                                                                }
                                                            }
                                                            ?>
                                                            <input type="checkbox" <?php if ($status != null) {
                                                                echo 'checked';
                                                            } ?> class="checkbox"
                                                                name="menu_id[]" value="{{ $item['menu_id'] }}">
                                                        </td>
                                                        <td>
                                                            <h5 class="text-white">{{ strtoupper($item['nama_menu']) }}
                                                            </h5>
                                                            @if ($item['parent_id'] == 0)
                                                            @else
                                                                <h5 class="text-primary">&nbsp;&nbsp;&nbsp;
                                                                    {{ strtoupper($item['nama_menu']) }}</h5>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item['url_menu'] }}</td>
                                                    </tr>
                                                    @foreach ($item['submenu'] as $submenu)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" <?php if (array_search($submenu['menu_id'], $menu_akses) != null) {
                                                                    echo 'checked';
                                                                } ?> class="checkbox"
                                                                    name="menu_id[]" value="{{ $submenu['menu_id'] }}">
                                                            </td>
                                                            <td>
                                                                <p class="text-danger">
                                                                    &nbsp;&nbsp;&nbsp;{{ strtoupper($submenu['nama_menu']) }}
                                                                </p>
                                                            </td>
                                                            <td>{{ $submenu['url_menu'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
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
@endsection
