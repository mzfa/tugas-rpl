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
<div class="mb-3">
    <label for="staticEmail" class="form-label">Gambar</label>
    <div class="dropzone">
        <div class="fallback">
            <input name="file" type="file" multiple="multiple">
        </div>
        <div class="dz-message needsclick">
            <div class="mb-3">
                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
            </div>

            <h4>Drop files here or click to upload.</h4>
        </div>
    </div>

    <ul class="list-unstyled mb-0" id="dropzone-preview">
        <li class="mt-2" id="dropzone-preview-list">
            <!-- This is used as the file preview template -->
            <div class="border rounded">
                <div class="d-flex p-2">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-light rounded">
                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="pt-1">
                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                    </div>
                    <div class="flex-shrink-0 ms-3">
                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
<input type="hidden" name="barang_id" value="{{ $data->barang_id }}">
<input type="hidden" name="gambar" value="{{ $data->gambar }}">