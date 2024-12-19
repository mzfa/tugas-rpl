@extends('layouts.app')

@section('styles')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,
                // select: function(arg) {
                //     var title = prompt('Event Title:');
                //     if (title) {
                //         calendar.addEvent({
                //             title: title,
                //             start: arg.start,
                //             end: arg.end,
                //             allDay: arg.allDay
                //         })
                //     }
                //     calendar.unselect()
                // },
                eventClick: function(arg) {
                    console.log(arg.event.groupId)
                    let id = arg.event.groupId;
                    $.ajax({
                        type: 'get',
                        url: "{{ url('calendar/edit') }}/" + id,
                        // data:{'id':id}, 
                        success: function(tampil) {
                            $('#tampildata').html(tampil);
                            $('#editModal').modal('show');
                        }
                    })

                },
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: {!! $eventnya !!},
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });

            calendar.render();
        });
    </script>
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Departement</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Event Kalender</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <strong>{{ $error }} <br></strong>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <h5 class="card-title">Event Kalender</h5>

                            <!-- Table with stripped rows -->
                            <div class="row">
                                <div class="col-md-3">
                                    <form action="{{ url('calendar/store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Tambah Data</h5>
                                            </div>
                                            <div class="card-body mb-3">
                                                <div class="mb-3 mt-3">
                                                    <label for="staticEmail" class="form-label">Agenda</label>
                                                    <input type="text" class="form-control" id="agenda" name="agenda"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="staticEmail" class="form-label">Tempat Event</label>
                                                    <input type="text" class="form-control" id="tempat_event"
                                                        name="tempat_event" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="staticEmail" class="form-label">Tanggal Awal</label>
                                                    <input type="datetime-local" class="form-control" id="tanggal_awal"
                                                        name="tanggal_awal" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="staticEmail" class="form-label">Tanggal Akhir</label>
                                                    <input type="datetime-local" class="form-control" id="tanggal_akhir"
                                                        name="tanggal_akhir" required>
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <label for="staticEmail" class="form-label">Kehadiran</label>
                                                    <select class="select2-multiple form-control" name="kehadiran[]"
                                                        multiple="multiple">
                                                        @foreach ($data as $item)
                                                            <option value="{{ $item->departement_id }}">{{ $item->peran }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                            </div>
                                            <div class="card-footer">
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-9">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ url('calendar/update') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="tampildata"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function edit(id) {
            // let filter = $(this).attr('id'); 
            // filter = filter.split("-");
            // var tfilter = $(this).attr('id');
            // console.log(id);
            $.ajax({
                type: 'get',
                url: "{{ url('departement/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {

                    // console.log(tampil); 
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }

        $(document).ready(function() {
            $('.select2-multiple').select2();
        });
    </script>
@endsection
