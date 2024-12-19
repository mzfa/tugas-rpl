<div class="table-responsive">
    <div class="mb-3">
        <label for="staticEmail" class="form-label">Tanggal Penerimaan</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $penerimaan->tanggal }}" required>
    </div>
    <div class="mb-3">
        <label for="staticEmail" class="form-label">Faktur</label>
        <input type="text" class="form-control" id="faktur" name="faktur" value="{{ $penerimaan->faktur }}" required>
    </div><br>
    <table class="table align-middle table-nowrap" id="customerTable">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                    </div>
                </th>
                <th class="sort" data-sort="customer_nama">Nama Barang</th>
                <th class="sort" data-sort="customer_nama">Kode Barang</th>
                <th class="sort" data-sort="customer_nama">Satuan</th>
                <th class="sort" data-sort="customer_nama">Pesan</th>
                <th class="sort" data-sort="customer_nama">Terima</th>
                <th class="sort" data-sort="customer_nama">Batch</th>
                <th class="sort" data-sort="customer_nama">Exp</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($data as $item)
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if(in_array($item->barang_id,$pemesanan_detail)) checked @endif name="barang_id[]" value="{{ $item->barang_id }}">
                        </div>
                    </th>
                    <td class="customer_name">{{ $item->nama }}</td>
                    <td class="customer_name">{{ $item->kode_barang }}</td>
                    <td class="customer_name">{{ $item->satuan }}</td>
                    <td class="customer_name">{{ $jumlah[$item->barang_id] ?? '' }}</td>
                    <td class="customer_name">
                        <input type="number" class="form-control" name="terima[{{ $item->barang_id }}]" value="{{ $item->terima ?? '' }}">
                        <input type="hidden" class="form-control" name="satuan[{{ $item->barang_id }}]" value="{{ $item->satuan }}">
                        <input type="hidden" class="form-control" name="harga_jual[{{ $item->barang_id }}]" value="{{ $item->harga_jual }}">
                        <input type="hidden" class="form-control" name="pemesanan_detail_id[{{ $item->barang_id }}]" value="{{ $pemesanan_detail_id[$item->barang_id] ?? '' }}">
                        <input type="hidden" class="form-control" name="penerimaan_detail_id[{{ $item->barang_id }}]" value="{{ $pemesanan_detail_id[$item->barang_id] ?? '' }}">
                        <input type="hidden" class="form-control" name="penerimaan_id" value="{{ $penerimaan_id[$item->barang_id] ?? '' }}">
                    </td>
                    <td><input type="text" class="form-control" name="batch[{{ $item->barang_id }}]" value="{{ $item->batch ?? '' }}"></td>
                    <td><input type="date" class="form-control" name="expired[{{ $item->barang_id }}]" value="{{ $item->expired ?? '' }}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="pemesanan_id" value="{{ $id }}">