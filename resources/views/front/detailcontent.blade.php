@extends('catalog.index')

@section('content')
<div class="container">
    <a href="/catalogue" style="position:absolute; left: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <div class="row">
        <div class="col-6">
            <img class="img-thumbnail" width="500" height="50" src="{{ $detail->photo }}" alt="Product Image"> <!-- Menggunakan data produk untuk menampilkan gambar -->
        </div>
        <div class="col-6">
            <h2>{{ $detail->nama_produk }}</h2> <!-- Menampilkan nama produk -->
            <p>{{ $detail->desc }}</p> <!-- Menampilkan deskripsi produk -->
            <div class="button mt-5">
                <a href="{{ route('cart.add', ['id' => $detail->id]) }}" type="button" class="btn btn-success"><i class="bi-cart"></i> Keranjang</a>
                <a href="{{ route('wishlist.add', ['id' => $detail->id]) }}" class="btn btn-outline-danger"><i class="bi-heart"></i> Suka</a>
            </div>
        </div>
    </div>
</div>
<div id="checkoutModal-{{ $detail->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel-{{ $detail->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('send-accpenjualan', ['id' => $detail->id]) }}" method="post" class="mb-4 checkout-form" data-detail-id="{{ $detail->id }}">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="jumlah" class="col-lg-2 col-lg-offset-1 control-label">Jumlah</label>
                        <div class="col-lg-12">
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pesan" class="col-lg-2 col-lg-offset-1 control-label">Pesan</label>
                        <div class="col-lg-12">
                            <textarea type="text" name="pesan" id="pesan" class="form-control" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Checkout</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script>
    $(document).ready(function() {
        $('.checkout-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('detail-id');
            $('#checkoutModal-' + productId).modal('show');
        });
    });
</script>
@endsection