@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Update User
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text" placeholder="Input Name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email">Email address</label>
                <input class="form-control" name="email" type="email" placeholder="Input Email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="password">Password (Leave blank to keep current password)</label>
                <input class="form-control" name="password" type="password" placeholder="Input Password">
            </div>
            <div class="mb-3">
                <label for="phone">Phone</label>
                <input class="form-control" name="phone" type="text" placeholder="Input Phone" value="{{ old('phone', $user->phone) }}" required>
            </div>
            <div class="mb-3">
                <label for="address">Address</label>
                <input class="form-control" name="address" type="text" placeholder="Input Address" value="{{ old('address', $user->address) }}" required>
            </div>
            <div class="mb-3">
                <label for="picture">Choose a profile picture:</label>
                <input class="form-control" type="file" name="picture" />
                @if($user->picture)
                    <img src="{{ asset('images/' . $user->picture) }}" alt="{{ $user->name }}" style="width: 50px; height: 50px;">
                @endif
            </div>
            <div class="form-group">
                <label><b>Role</b> <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="status" required>
                    <option value="" disabled>Choose Role</option>
                    <option value="admin" {{ $user->status == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->status == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update Data</button>
            </div>
        </form>
    </div>
</div>

@endsection
