@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Produk</li>
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
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($produk as $produks)
                            <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{ $produks->kode_produk }}</td>
                            <td>
                                <img src="{{ $produks->photo }}" class="img-thumbnail" width="50" height="50">
                            </td>
                            <td>{{ $produks->nama_produk }}</td>
                            <td>{{ $produks->kategori->nama_kategori }}</td>
                            <td>{{ $produks->merk }}</td>
                            <td>{{ $produks->harga_beli }}</td>
                            <td>{{ $produks->harga_jual }}</td>
                            <td>{{ $produks->diskon }}</td>
                            <td>{{ $produks->stok }}</td>
                            <td class="text-center align-middle" >
                                <a onclick="editForm({{ route('produk.update', $produks->id) }}')" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a onclick="deleteData('{{ route('produk.destroy', $produks->id) }}')" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Delete
                                </a>

                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
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
    //             url: '{{ route('produk.data') }}',
    //         },
    //         columns: [
    //             {data: 'select_all', searchable: false, sortable: false},
    //             {data: 'DT_RowIndex', searchable: false, sortable: false},
    //             {data: 'kode_produk'},
    //             {data: 'nama_produk'},
    //             {data: 'nama_kategori'},
    //             {data: 'merk'},
    //             {data: 'harga_beli'},
    //             {data: 'harga_jual'},
    //             {data: 'diskon'},
    //             {data: 'stok'},
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

    //     $('[name=select_all]').on('click', function () {
    //         $(':checkbox').prop('checked', this.checked);
    //     });
    // });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Produk');

    // Reset the form
    $('#edit-form')[0].reset();

    // Set the form action and method
    $('#edit-form').attr('action', url);
    $('#edit-form [name=_method]').val('put');
    $('#edit-form [name=nama_produk]').focus();

    // Fetch data and populate form fields
    $.get(url)
        .done((response) => {
            $('#edit-form [name=nama_produk]').val(response.nama_produk);
            $('#edit-form [name=id_kategori]').val(response.id_kategori);
            $('#edit-form [name=merk]').val(response.merk);
            $('#edit-form [name=harga_beli]').val(response.harga_beli);
            $('#edit-form [name=harga_jual]').val(response.harga_jual);
            $('#edit-form [name=diskon]').val(response.diskon);
            $('#edit-form [name=stok]').val(response.stok);
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
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
