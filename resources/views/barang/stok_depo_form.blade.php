<div class="mb-3">
    <label for="staticEmail" class="form-label">Batch</label>
    <input type="text" class="form-control" id="batch" value="{{ $stok_depo->batch }}" name="batch" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Jumlah Barang</label>
    <input type="number" class="form-control" id="jumlah_barang" value="{{ $stok_depo->jumlah_barang }}" name="jumlah_barang" required>
</div>
<div class="mb-3">
    <label for="staticEmail" class="form-label">Lokasi Rak</label>
    <select name="rak_id" id="rak_id" class="form-control" required>
        <option value=""></option>
        @foreach ($rak as $item2)
            <option @if($stok_depo->rak_id == $item2->rak_id) selected @endif value="{{ $item2->rak_id ?? null }}">{{ $item2->nama ?? null }}</option>
        @endforeach
    </select>
</div>
<input type="hidden" name="stock_real_id" value="{{ $stok_depo->stock_real_id }}">
<input type="hidden" name="jumah_sebelumnya" value="{{ $stok_depo->jumlah_barang }}">