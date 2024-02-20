@extends('layouts.master')

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Kategori</li>
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
                <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Kategori</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $kategoris)
                            <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{ $kategoris->nama_kategori }}</td>
                            <td class="text-center align-middle" >
                                <a onclick="editForm('{{ route('kategori.update', $kategoris->id_kategori) }}')" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a onclick="deleteData('{{ route('kategori.destroy', $kategoris->id_kategori) }}')" class="btn btn-danger">
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
