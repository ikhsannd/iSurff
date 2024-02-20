@extends('layouts.master')

@section('title')
    Daftar Stok
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Stok</li>
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
                <button onclick="addForm('{{ route('stok.store') }}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Produk</th>
                            <th>Stok Masuk</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($stok as $kategoris)
                            <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{ $kategoris->produk->nama_produk }}</td>
                            <td>{{ $kategoris->stok_masuk }}</td>
                            <td>{{ $kategoris->tanggal }}</td>
                            <td>{{ $kategoris->keterangan }}</td>
                            <td class="text-center align-middle" >
                                <a onclick="editForm('{{ route('edit-stok', $kategoris->id) }}')" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a onclick="deleteData('{{ route('delete-stok', $kategoris->id) }}')" class="btn btn-danger">
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

@includeIf('kategori.form')
@endsection

@push('scripts')
<script>

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Stok');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=tanggal]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Stok');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=tanggal]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=produk_id]').val(response.produk_id);
                $('#modal-form [name=stok_masuk]').val(response.stok_masuk);
                $('#modal-form [name=tanggal]').val(response.tanggal);
                $('#modal-form [name=keterangan]').val(response.keterangan);
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
