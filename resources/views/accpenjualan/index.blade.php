@extends('layouts.master')

@section('title')
Daftar Penjualan
@endsection

@section('breadcrumb')
@parent
<li class="active">Daftar Penjualan</li>
@endsection

@section('content')
<div class="row">
    @if (Session::has('message'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{ Session::get('message') }}!</strong>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{ Session::get('error') }}!</strong>
    </div>
    @endif
    <div class="col-lg-12">
        <div class="box">
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
                        <th width="15%"><i class="fa fa-cog"></i></th>
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
                                @if ($penjualan->status == 'Terkirim')
                                <span class="btn btn-success">{{ $penjualan->status }}</span>
                                @else
                                <a class="btn btn-warning" role="button">{{ $penjualan->status }}</a>
                                @endif
                            </td>
                            <td>
                                @if ($penjualan->status != 'Terkirim' && $penjualan->status_pembayaran == 'Dibayar')
                                <form action="{{ route('update-accpenjualan', ['id' => $penjualan->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Terima</button>
                                </form>
                                @elseif($penjualan->status == 'Terkirim' && $penjualan->status_pembayaran == 'Dibayar')
                                <button type="submit" class="btn btn-success">Selesai</button>
                                @else
                                <span class="btn btn-danger">Belum Dibayar<span>
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

@includeIf('kategori.form')
@endsection

@push('scripts')
<script>
    // let table;

    // $(function () {
    //     table = $('.table').DataTable({
    //         responsive: true,
    //         processing: true,
    //         serverSide: true,
    //         autoWidth: false,
    //         ajax: {
    //             url: '{{ route('kategori.data') }}',
    //         },
    //         columns: [
    //             {data: 'DT_RowIndex', searchable: false, sortable: false},
    //             {data: 'nama_kategori'},
    //             {data: 'aksi', searchable: false, sortable: false},
    //         ]
    //     });

    //     $('#modal-form').validator().on('submit', function (e) {
    //         if (! e.preventDefault()) {
    //             $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
    //                 .done((response) => {
    //                     $('#modal-form').modal('hide');
    //                     table.ajax.reload();
    //                 })
    //                 .fail((errors) => {
    //                     alert('Tidak dapat menyimpan data');
    //                     return;
    //                 });
    //         }
    //     });
    // });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    location.reload();
                    alert('berhasil menghapus data');
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush