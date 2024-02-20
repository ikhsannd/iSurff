@extends('catalog.index')

@section('content')
<div class="container" style="min-height: 100vh;">
    <a href="{{ back()->getTargetUrl() }}" style="position:absolute; left: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <div class="row" style="margin-top: 40px;">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5>Keranjang</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Produk</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $cartItem)
                            <tr>
                                <td><img class="img-thumbnail" width="150" height="150" src="{{ $cartItem->produk->photo }}" /></td>
                                <td>{{ $cartItem->produk->nama_produk }}</td>
                                <td>Rp. {{ $cartItem->produk->harga_jual }}</td>
                                <td>
                                    <div class="row g-0">
                                        <div class="col-6">
                                            <form action="{{ route('cart.update', $cartItem->id) }}" method="post" class="mb-2">
                                                @csrf
                                                @method('post')
                                                <input type="number" style="width: 100px;" name="stok" value="{{ $cartItem->stok }}" min="1" class="form-control">
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <form method="post" action="{{ route('cart.destroy', $cartItem->id) }}" id="deleteForm{{ $cartItem->id }}">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $cartItem->id }})"><i class="bi-trash"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <form method="post" action="{{ route('add-accpenjualan', $cartItem->id) }}" id="checkoutFormCash{{ $cartItem->id }}">
                                                @csrf
                                                <input type="hidden" name="tipe_pembayaran" value="Cash">
                                                <button type="button" class="btn btn-primary" onclick="confirmCheckout({{ $cartItem->id }})"><i class="bi-check"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Keranjang kosong.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5>Detail Informasi</h5>
                    @php
                    $totalBayar = 0;
                    @endphp
                    @foreach($cartItems as $cartItem)
                    @php
                    $totalBayar += $cartItem->produk->harga_jual * $cartItem->stok;
                    @endphp
                    @endforeach
                    <p class="total-harga"><strong>Total Bayar: </strong>{{ $totalBayar }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(cartItemId) {
        Swal.fire({
            title: "Konfirmasi Penghapusan",
            text: "Apakah Anda yakin ingin menghapus produk dari keranjang?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + cartItemId).submit();
            }
        });
    }

    function confirmCheckout(cartItemId) {
        Swal.fire({
            title: "Pilih Pembayaran",
            text: "Pilih Pembayaran Dengan Tepat",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#1500ff",
            confirmButtonColor: "#00ab14",
            cancelButtonText: "Pembayaran Digital",
            confirmButtonText: "Cash"
        }).then((result) => {
            if (result.isConfirmed) {
                // If Cash payment is selected
                document.getElementById('checkoutFormCash' + cartItemId).submit();
            }
            if (result.isDismissed) {
                var url = `/add-accpenjualan/${cartItemId}`;
                const formData = new FormData();

                formData.append('tipe_pembayaran',
                    'Online');

                axios.post(url, formData).then(res => {
                    snap.pay(res.data.snap_token.snap_token, {
                        onSuccess: function(result) {
                            window.location = '/front/pesanan'
                        },
                        onPending: function(result) {
                            window.location = '/front/pesanan'
                        },
                        onClose: function(result) {
                            window.location = '/front/pesanan'
                        },
                    })
                })
            }
        });
    }
</script>

@endsection