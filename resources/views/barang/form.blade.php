<div class="mb-3">
    <label for="staticEmail" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Kategori Barang</label>
    <select name="kategori" id="kategori" class="form-control">
        <option value=""></option>
        <option value="Kategori A">Kategori A</option>
    </select>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Satuan Barang</label>
    <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $data->satuan }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Stok Minimal</label>
    <input type="number" class="form-control" id="stok_minimal" name="stok_minimal" value="{{ $data->stok_minimal }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Stok Maksimal</label>
    <input type="number" class="form-control" id="stok_maksimal" name="stok_maksimal" value="{{ $data->stok_maksimal }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Harga Jual</label>
    <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ $data->harga_jual }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Harga Beli</label>
    <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $data->harga_beli }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Lokasi</label>
    <select name="lokasi" id="lokasi" class="form-control">
        <option value=""></option>
        <option value="Gudang A">Gudang A</option>
    </select>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Keterangan</label>
    <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control">{{ $data->keterangan }}</textarea>
</div>
<input type="hidden" name="barang_id" value="{{ $data->barang_id }}">