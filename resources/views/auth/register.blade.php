@extends('layouts.auth')

@section('login')
<div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body mb-5">
        <div class="login-logo">
            <h1> Register</h1>
        </div>

        <form action="{{ route('send-register') }}" method="post" class="form-login">
            @csrf
            <label for="nama" class="control-label">Nama</label>
            <div class="form-group has-feedback @error('name') has-error @enderror">
                <input type="name" name="name" class="form-control" placeholder="name" required value="{{ old('name') }}" autofocus>
                <span class="form-control-feedback"></span>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @error('name')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <label for="nama" class="control-label">Email</label>
            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <label for="nama" class="control-label">Alamat</label>
            <div class="form-group has-feedback @error('alamat') has-error @enderror">
                <input type="alamat" name="alamat" class="form-control" placeholder="alamat" required value="{{ old('alamat') }}" autofocus>
                <span class="glyphicon glyphicon-pawn form-control-feedback"></span>
                @error('alamat')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <label for="nama" class="control-label">Telepon</label>
            <div class="form-group has-feedback @error('no_telp') has-error @enderror">
                <input type="no_telp" name="no_telp" class="form-control" placeholder="Telepon" required value="{{ old('no_telp') }}" autofocus>
                <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                @error('no_telp')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <label for="nama" class="control-label">Password</label>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @error('password')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <input type="hidden" name="role_id" value="2">
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Simpan</button>
                </div>
                <!-- /.col -->
            </div>
    </div>
    </form>

</div>
<!-- /.login-box -->
@endsection