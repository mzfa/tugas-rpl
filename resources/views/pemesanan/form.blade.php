<div class="mb-3">
    <label for="staticEmail" class="form-label">Nama Supplier</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama ?? null }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Tanggal Awal</label>
    <input type="date" class="form-control" id="kategori" name="tgl_awal" value="{{ $data->tgl_awal ?? null }}" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Tanggal Akhir</label>
    <input type="date" class="form-control" id="stok_minimal" name="tgl_akhir" value="{{ $data->tgl_akhir ?? null }}" required>
</div>
<input type="hidden" name="supplier_id" value="{{ $data->supplier_id ?? null }}">