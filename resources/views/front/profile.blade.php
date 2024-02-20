@extends('catalog.index')

@section('content')
<div class="container" style="height: 100vh;">
    <a href="/catalogue" style="position:absolute; left: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
        </svg></a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header mt-100px">
                    <h4>Profile</h4>
                </div>
                <div class="card-body">
                    {{-- Display user information --}}
                    <div class="mb-3">
                        <strong>Nama:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Alamat:</strong> {{ $user->alamat }}
                    </div>
                    <div class="mb-3">
                        <strong>Telepon:</strong> {{ $user->no_telp }}
                    </div>
                    {{-- Add more user details as needed --}}

                    {{-- Update button --}}
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateModal">
                        Update Profile
                    </button>
                    @auth
                    <a href="{{ route('profile.orders') }}" class="btn btn-outline-success">
                        Order
                        <span class="badge bg-success text-white ms-1 rounded-pill">{{ count(auth()->user()->order ?? []) }}</span>
                        @else
                        <a href="{{ route('profile.orders') }}" class="btn btn-outline-success">
                            Order
                            <span class="badge bg-success text-white ms-1 rounded-pill">0</span>
                            @endauth
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Update Profile Modal --}}
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Add your update form here --}}
                <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    {{-- Add form fields for updating user details --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Telepon</label>
                        <input type="string" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="string" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" aria-describedby="passwordHelpInline" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection