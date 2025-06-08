<div class="mb-3 form-group">
    <label>Referensi</label>
    <select name="referensi_id" class="form-control">
        <option value="">Pilih Referensi Gudang</option>
        @foreach ($gudang as $item)
            <option @if($data->referensi_id == $item->gudang_id) selected @endif value="{{ $item->gudang_id }}">{{ $item->nama }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Nama Rak</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Kapasitas</label>
    <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="{{ $data->kapasitas }}" required>
</div>
<input type="hidden" name="rak_id" value="{{ $data->rak_id }}">