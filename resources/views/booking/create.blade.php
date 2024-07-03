@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Booking
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

        <form action="{{ route('booking.store', ) }}" method="POST" enctype="multipart/form-data">
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
        
            <div class="mb-3">
                <label for="room">Room</label>
                <select class="form-control" name="rooms_id" required>
                    <option value="">Select Room</option>
                    @foreach($room as $room)
                        <option value="{{ $room->id }}" {{ old('rooms_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->type }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label for="day">Day</label>
                <input class="form-control" name="day" type="number" min="1" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
