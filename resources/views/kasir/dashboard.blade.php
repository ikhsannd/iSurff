@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body text-center">
                 @if (auth()->check() && (auth()->user()->role->id == 2))
                 <h1>Selamat Datang, Anda login sebagai pembeli</h1>
                 <h3>Silahkan pilih produk yang kamu mau beli!</h3>
                @else
                <h1>Selamat Datang, Anda login sebagai penjual</h1>
                <h3>Silahkan buat produk kamu sekarang!</h3>
                @endif
                <br><br>

                @if (auth()->check() && (auth()->user()->role->id == 3))
                <a href="{{ route('catalog.index') }}" class="btn btn-success btn-lg">Home</a>
                @else
                <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg">Transaksi Baru</a>
                @endif

                <br><br><br>
            </div>
        </div>
    </div>
</div>
<!-- /.row (main row) -->
@endsection
