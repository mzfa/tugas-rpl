@extends('layouts.tamplate')

@section('content')
<div class="mb-3">
    <label for="staticEmail" class="form-label">Agenda</label>
    <input type="text" class="form-control" id="agenda" name="agenda" value="{{ $data[0]->agenda }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Tempat Event</label>
    <input type="text" class="form-control" id="tempat_event" name="tempat_event" value="{{ $data[0]->tempat_event }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Tanggal Awal</label>
    <input type="text" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ $data[0]->tanggal_awal }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Tanggal Akhir</label>
    <input type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ $data[0]->tanggal_akhir }}" required>
</div>
<input type="hidden" class="form-control" id="event_id" name="event_id" value="{{ Crypt::encrypt($data[0]->event_id) }}" required>
<a href="{{ url('calendar/delete/'.Crypt::encrypt($data[0]->event_id)) }}" class="btn btn-danger btn-block w-100">Hapus</a>
@endsection
