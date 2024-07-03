@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Edit Room
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

        <form action="{{ route('room.update', $room->id ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="homestay">Homestay</label>
                <select class="form-control" name="homestays_id" required>
                    <option value="">Select Homestay</option>
                    @foreach($homestays as $homestay)
                        <option value="{{ $homestay->id }}" {{ old('homestays_id', $room->homestays_id) == $homestay->id ? 'selected' : '' }}>
                            {{ $homestay->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="type">Type</label>
                <input class="form-control" name="type" type="text" placeholder="Input Type" value="{{ old('type',$room->type) }}" required>
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" placeholder="Input Description" required>{{ old('description',$room->description) }}</textarea>
            </div>   
            <div class="mb-3">
                <label for="quota">Quota</label>
                <input class="form-control" name="quota" type="number" placeholder="Input Quota" value="{{ old('quota',$room->quota) }}" required>
            </div> 
            <div class="mb-3">
                <label for="price">Price</label>
                <input class="form-control" name="price" type="number" placeholder="Input Price" value="{{ old('price',$room->price) }}" required>
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