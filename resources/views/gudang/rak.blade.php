@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Data Rak</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Data Rak</li>
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
                        <h4 class="card-title mb-0">Data Rak</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($data as $item)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            {{ $item->nama }}
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @for ($i = 1; $i <= $item->kapasitas; $i++)
                                                    <div class="col">
                                                        <div class="card card-body bg-success text-white">
                                                            {{ $i }}
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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


@section('scripts')
<script>
    function edit(id){
        $.ajax({ 
            type : 'get',
            url : "{{ url('gudang/edit')}}/"+id,
            // data:{'id':id}, 
            success:function(tampil){
                $('#tampildatagudang').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
</script>

@endsection