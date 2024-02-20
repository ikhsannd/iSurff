@extends('catalog.index')

@section('content')
@if (Session::has('message'))
<div class="alert alert-success" role="alert" style="height: 50px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{ Session::get('message') }}!</strong>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-success" role="alert" style="height: 50px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{{ Session::get('error') }}!</strong>
</div>
@endif
<div class="row" style="min-height: 100vh; padding: 20px; margin-bottom: 100px;">
    <a href="/catalogue" style="position:absolute; left: 0px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <h3 class="mt- px-5">Pesanan</h3>
    <div class="col-lg-12">
        <div class="box mt-1">
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Harga Produk</th>
                        <th>Ongkir</th>
                        <th>Total Bayar</th>
                        <th>Pesan Dari Pembeli</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $penjualan)
                        <tr>
                            <td>{{ $penjualan->produk->kode_produk }}</td>
                            <td>{{ $penjualan->produk->nama_produk }}</td>
                            <td>{{ $penjualan->jumlah }}</td>
                            <td>Rp {{ number_format($penjualan->produk->harga_jual) }}</td>
                            <td>Rp {{ number_format($penjualan->ongkir) }}</td>
                            <td>Rp {{ number_format($penjualan->total_bayar) }}</td>
                            <td>{{ $penjualan->pesan }}</td>
                            <td>
                                @if ($penjualan->status == 'Terkirim' && $penjualan->status_pembayaran == 'Dibayar')
                                <span class="btn btn-success">{{ $penjualan->status }}</span>
                                @elseif($penjualan->status == 'Menunggu' && $penjualan->status_pembayaran == 'Dibayar')
                                <a class="btn btn-warning" role="button">{{ $penjualan->status }}</a>
                                @elseif($penjualan->status == 'Menunggu' && $penjualan->status_pembayaran == 'Belum Dibayar')
                                <span class="btn btn-success" id="pay-button_{{ $penjualan->id }}" data-snap-token="{{ $penjualan->snap_token }}">Bayar Sekarang</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentButtons = document.querySelectorAll('[id^="pay-button"]');

    paymentButtons.forEach(function(paymentButton) {
        paymentButton.addEventListener('click', function() {
            const snapToken = paymentButton.dataset.snapToken;

            try {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = '/front/pesanan'
                    },
                    onPending: function(result) {
                        window.location.href = '/front/pesanan'
                    },
                    onClose: function(result) {
                        window.location.href = '/front/pesanan'
                    }
                });
            } catch (error) {
                console.error('Error during fetch:', error);
            };

        });
    });
</script>

@endsection