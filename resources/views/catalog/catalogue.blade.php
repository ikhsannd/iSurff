@extends('catalog.index')

@section('content')
<section id="billboard" class="position-relative bg-light-blue" style="min-height: 100vh;">
    <div id="carouselExampleIndicators" class="carousel slide mx-auto" data-ride="carousel" style="width: 100%; height:470px;">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block" style="width: 100%; height: 470px; object-fit: cover;" src="{{asset('/img/gambar3.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block" style="width: 100%; height: 470px; object-fit: cover;" src="{{asset('/img/gambar1.jpg')}}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block" style="width: 100%; height: 470px; object-fit: cover;" src="{{asset('/img/gambar2.jpg')}}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="swiper main-swiper">
        <div class="swiper-wrapper ">
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 mt-5 mb-5">
                            <div class="banner-content" style="margin-bottom: 50px;">
                                <h1 class="display-2 text-uppercase text-dark pb-5">Selamat datang di website resmi</h1>
                                <a href="/catalogue" class="btn btn-medium btn-dark text-uppercase btn-rounded-none" style="background-color: #474F7A;">Mulai belanja</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function wishlist() {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "Berhasil Disimpan",
            showConfirmButton: true
        });
    }
    $(document).ready(function() {
        $('.carousel').carousel();
    });
</script>



@endsection