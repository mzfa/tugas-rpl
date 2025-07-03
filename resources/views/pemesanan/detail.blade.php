<div class="table-responsive">
    <table class="table align-middle table-nowrap mt-3" id="customerTable">
        <thead class="table-light">
            <tr>
                <th class="sort" data-sort="customer_nama">Nama Barang</th>
                <th class="sort" data-sort="customer_nama">Kode Barang</th>
                <th class="sort" data-sort="customer_nama">Satuan</th>
                <th class="sort" data-sort="customer_nama">Pesan</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($data as $item)
                <tr>
                    <td class="customer_name">{{ $item->nama }}</td>
                    <td class="customer_name">{{ $item->kode_barang }}</td>
                    <td class="customer_name">{{ $item->satuan }}</td>
                    <td class="customer_name">{{ $jumlah[$item->barang_id] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>