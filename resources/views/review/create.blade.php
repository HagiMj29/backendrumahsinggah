@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Review
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

        <form action="{{ route('review.store', ) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input untuk user_id, homestays_id, rooms_id, day, status -->
            <div class="mb-3">
                <label for="user">User</label>
                <select class="form-control" name="user_id" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label for="homestay">Homestay</label>
                <select class="form-control" name="homestays_id" required>
                    <option value="">Select Homestay</option>
                    @foreach($homestays as $homestay)
                        <option value="{{ $homestay->id }}" {{ old('homestays_id') == $homestay->id ? 'selected' : '' }}>
                            {{ $homestay->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group">
                <label><b>Rating</b> <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="rating" required>
                    <option value="" disabled selected>Choose Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="review">Review</label>
                <textarea class="form-control" name="review" placeholder="Input Description" required>{{ old('review') }}</textarea>
            </div> 
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
