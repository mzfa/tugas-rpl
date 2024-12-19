<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Nama struktur</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="nama_struktur" name="nama_struktur" value="{{ $data->nama_struktur }}" required>
    </div>
</div>
<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Akronim (Singkatan)</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" id="akronim" name="akronim" value="{{ $data->akronim }}" required>
    </div>
</div>
<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Referensi Bagian</label>
    <div class="col-sm-10">
    <select class="form-control" name="parent_id">
        <option value="0">Rumah Sakit</option>
        @foreach($struktur as $item)
            <option value="{{ $item->struktur_id }}" @if($item->struktur_id == $data->parent_id) selected @endif>{{ $item->nama_struktur }}</option>
        @endforeach
    </select>
    </div>
    <input type="hidden" name="satusehat_id" value="{{ $data->satusehat_id }}">
</div>
<input type="hidden" class="form-control" id="struktur_id" name="struktur_id" value="{{ Crypt::encrypt($data->struktur_id) }}" required>