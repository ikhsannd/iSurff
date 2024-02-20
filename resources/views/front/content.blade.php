@extends('catalog.index')

@section('content')
<div class="container px-4 px-lg-5 mt-3" style="height: 100vh;">
<a href="/" style="position:absolute; left: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <form action="{{ route('catalog.index') }}" method="GET">
        <div class="row g-2">
            <div class="col-4">
                <label for="min_price">Min Price:</label>
                <input type="number" class="form-control" name="min_price" id="min_price" value="{{ $minPrice }}">
            </div>
            <div class="col-4">
                <label for="max_price">Max Price:</label>
                <input type="number" class="form-control" name="max_price" id="max_price" value="{{ $maxPrice }}">
            </div>
            <div class="col-4 pt-4">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </div>
    </form>
    <div class="container">
        @php $count = 0; @endphp
        <div class="row">
            @foreach($produkfront as $product)
            @if($count % 3 == 0)
        </div>
        <div class="row">
            @endif
            <div class="col-4 mb-5 mt-3">
                <div class="col-sm mb-5">
                    <div class="card position-relative">
                        <a href="{{ route('wishlist.add', ['id' => $product->id]) }}" class="position-absolute top-0 end-0 p-3 text-danger love-icon"><i class="bi-heart"></i></a>
                        <a style="text-decoration: none" href="{{ route('produk.detail', ['id' => $product->id]) }}">
                            <img class="card-img-top" width="500" height="150" src="{{ $product->photo }}" alt="..." style="object-fit: contain; padding: 5px;" />
                            <div class="card-body p-4">
                                <div style="color: black">
                                    <h5 class="fw-bolder">{{ $product->nama_produk }}</h5>
                                    Rp. {{ $product->harga_jual }}
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent d-flex justify-content-between" style="width: 100%;">
                                <div>
                                    <a class="btn btn-outline-primary mt-auto" style="width: 100%;" href="{{ route('cart.add', ['id' => $product->id]) }}"><i class="bi-cart-fill"></i></a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div id="checkoutModal-{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel-{{ $product->id }}" aria-hidden="true"> aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="checkoutModalLabel">Form Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('send-accpenjualan', ['id' => $product->id]) }}" method="post" class="mb-4 checkout-form" data-product-id="{{ $product->id }}">
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
            </div>
            @php $count++; @endphp
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script>
    $(document).ready(function() {
        $('.checkout-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            $('#checkoutModal-' + productId).modal('show');
        });
    });
</script>

@endsection