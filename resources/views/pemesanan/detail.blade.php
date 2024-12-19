<div class="table-responsive">
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
                <th class="sort" data-sort="customer_nama">Jumlah Barang</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($barang as $item)
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if(in_array($item->barang_id,$pemesanan_detail)) checked @endif name="barang_id[]" value="{{ $item->barang_id }}">
                        </div>
                    </th>
                    <td class="customer_name">{{ $item->nama }}</td>
                    <td class="customer_name">{{ $item->kode_barang }}</td>
                    <td class="customer_name">{{ $item->satuan }}</td>
                    <td class="customer_name">
                        <input type="number" class="form-control" name="jumlah[{{ $item->barang_id }}]" value="{{ $jumlah[$item->barang_id] ?? '' }}">
                        <input type="hidden" class="form-control" name="satuan[{{ $item->barang_id }}]" value="{{ $item->satuan }}">
                        <input type="hidden" class="form-control" name="harga_beli[{{ $item->barang_id }}]" value="{{ $item->harga_beli }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="pemesanan_id" value="{{ $id }}">