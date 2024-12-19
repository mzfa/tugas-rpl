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
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($barang as $item)
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" @if(in_array($item->barang_id,$paket_detail)) checked @endif name="barang_id[]" value="{{ $item->barang_id }}">
                        </div>
                    </th>
                    <td class="customer_name">{{ $item->nama }}</td>
                    <td class="customer_name">{{ $item->kode_barang }}</td>
                    <td class="customer_name">{{ $item->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="paket_id" value="{{ $id }}">