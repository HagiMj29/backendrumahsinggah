@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Edit Homestay
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

        <form action="{{ route('homestay.update', $homestay->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text" placeholder="Input Name" value="{{ old('name', $homestay->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="address">Address</label>
                <input class="form-control" name="address" type="text" placeholder="Input Address" value="{{ old('address', $homestay->address) }}" required>
            </div>
            <div class="mb-3">
                <label for="picture">Choose a picture:</label>
                <input class="form-control" type="file" name="picture" />
                @if($homestay->picture)
                    <img src="{{ asset('images/' . $homestay->picture) }}" alt="{{ $homestay->name }}" style="width: 50px; height: 50px;">
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Submit Data</button>
            </div>
        </form>
    </div>
</div>

@endsection
