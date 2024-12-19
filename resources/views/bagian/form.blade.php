<div class="mb-3 form-group">
    <label>Referensi</label>
    <select name="referensi_id" class="form-control">
        <option value="">Pilih Referensi Bagian</option>
        @foreach ($bagian as $item)
            <option @if($item->referensi_id == $data->bagian_id) checked @endif  value="{{ $item->bagian_id }}">{{ $item->nama_bagian }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Nama Bagian</label>
    <input type="text" class="form-control" id="nama_bagian" name="nama_bagian" value="{{ $data->nama_bagian }}" required>
</div>
<input type="hidden" name="bagian_id" value="{{ $data->bagian_id }}">