@extends('layouts.index')

@section('content')
<div class="container">
    <a href="/profile" style="position:absolute; left: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Order History</h4>
                </div>
                <div class="card-body">
                    @if($orders->isEmpty())
                    <p>Belum memiliki order, silahkan checkout barang terlebih dahulu.</p>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->produk->nama_produk }}</td>
                                <td>
                                    <span class="badge {{ $order->status === 'Menunggu' ? 'bg-warning' : ($order->status === 'Terkirim' ? 'bg-success' : '') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection