<style>
    .paragraph-spacing {
        margin-bottom: 10px;
    }
</style>
@extends('catalog.index')

@section('content')
<div class="container" style="min-height: 86vh;">
    <div class="section" style="padding-bottom: 6%">
        <h1><i class="bi bi-check2-circle" style="color: green"></i></h1>
        <h1 style="color: green">Checkout Sukses</h1>
        <h4>Pesanan Anda telah berhasil dicheckout. Terima kasih!</h4>

        @if ($data && $data->produk && $data->produk->user)
        <p class="paragraph-spacing">Nama Toko: {{ $setting->nama_perusahaan }}</p>
        <p class="paragraph-spacing">Alamat Toko: {{ $setting->alamat }}</p>
        <p class="paragraph-spacing">Nomor Whatsapp: {{ $setting->telepon }}</p>
        @else
        <p>Data tidak ditemukan</p>
        @endif
        <a href="{{ route('front.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@endsection