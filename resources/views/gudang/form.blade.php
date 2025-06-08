<div class="mb-3">
    <label for="staticEmail" class="form-label">Nama Gudang</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" required>
</div>
{{-- <div class="mb-3">
    <label for="staticEmail" class="form-label">Kapasitas (RAK)</label>
    <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="{{ $data->kapasitas }}" required>
</div> --}}
<input type="hidden" name="gudang_id" value="{{ $data->gudang_id }}">