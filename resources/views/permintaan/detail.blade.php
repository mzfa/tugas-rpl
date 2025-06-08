@php
    $status = ($permintaan->flag_selesai == 1) ? 'readonly' : '';
@endphp
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
                <th class="sort" data-sort="customer_nama">Nomor Batch</th>
                <th class="sort" data-sort="customer_nama">Expired</th>
                <th class="sort" data-sort="customer_nama">Gudang | RAK</th>
                <th class="sort" data-sort="customer_nama">Stock</th>
                <th class="sort" data-sort="customer_nama">Jumlah Barang</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @foreach ($barang as $item)
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input {{ $status }} class="form-check-input" type="checkbox" @if(in_array($item->barang_id,$permintaan_detail)) checked @endif name="barang_id[]" value="{{ $item->barang_id }}">
                        </div>
                    </th>
                    <td class="customer_name">{{ $item->nama_barang }}</td>
                    <td class="customer_name">{{ $item->batch }}</td>
                    <td class="customer_name">{{ $item->expired }}</td>
                    <td class="customer_name">{{ $item->nama_gudang.' | '.$item->nama_rak }}</td>
                    <td class="customer_name">{{ $item->jumlah_barang }}</td>
                    <td class="customer_name">
                        <input type="number" class="form-control" {{ $status }} name="jumlah[{{ $item->barang_id }}]" value="{{ $jumlah[$item->barang_id] ?? '' }}" max="{{ $item->jumlah_barang }}">
                        <input type="hidden" class="form-control" name="satuan[{{ $item->barang_id }}]" value="{{ $item->satuan }}">
                        <input type="hidden" class="form-control" name="barang_id[{{ $item->barang_id }}]" value="{{ $item->barang_id }}">
                        <input type="hidden" class="form-control" name="rak_id[{{ $item->barang_id }}]" value="{{ $item->rak_id }}">
                        <input type="hidden" class="form-control" name="expired[{{ $item->barang_id }}]" value="{{ $item->expired }}">
                        <input type="hidden" class="form-control" name="batch[{{ $item->barang_id }}]" value="{{ $item->batch }}">
                        <input type="hidden" class="form-control" name="jumlah_barang[{{ $item->barang_id }}]" value="{{ $item->jumlah_barang }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" name="permintaan_id" value="{{ $id }}">