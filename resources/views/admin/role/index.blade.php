@extends('layouts.master')

@section('title')
    Daftar Role
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Role</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="addForm('{{ route('role.simpan') }}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="text-center align-middle" >
                                <a onclick="editForm('{{ route('role.update', $role->id) }}')" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                    Edit
                                </a>
                                <a onclick="deleteData('{{ route('role.delete', $role->id) }}')" class="btn btn-danger">
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

@includeIf('admin.role.form')
@endsection

@push('scripts')
<script>
    
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Role');

        var form = $('#modal-form form')[0];
        if (form) {
            form.reset();
        }
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();
    }

    function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Role');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('PUT');
    $('#modal-form [name=name]').focus();
    
    $.get(url)
        .done((response) => {
            console.log(response);
            $('#modal-form [name=name]').val(response.name);
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

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, $('.form-role').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        } else {
            alert('Pilih data yang akan dihapus');
            return;
        }
    }
</script>
@endpush