@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Checkout Booking
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

        <form action="{{ route('booking.checkout',$booking->id ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Input untuk user_id, homestays_id, rooms_id, day, status -->
            <div class="mb-3">
                <label for="user">User</label>
                <select class="form-control" name="user_id" disabled>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id',$booking->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
            </div>
        
            <div class="mb-3">
                <label for="homestay">Homestay</label>
                <select class="form-control" name="homestays_id" disabled>
                    <option value="">Select Homestay</option>
                    @foreach($homestays as $homestay)
                        <option value="{{ $homestay->id }}" {{ old('homestays_id', $booking->homestays_id) == $homestay->id ? 'selected' : '' }}>
                            {{ $homestay->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="homestays_id" value="{{ $booking->homestays_id }}">
            </div>
        
            <div class="mb-3">
                <label for="room">Room</label>
                <select class="form-control" name="rooms_id" disabled>
                    <option value="">Select Room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('rooms_id',$booking->rooms_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->type }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="rooms_id" value="{{ $booking->rooms_id }}">
            </div>
        
            <div class="mb-3">
                <label for="day">Day</label>
                <input class="form-control" name="day" value="{{ old('day', $booking->day) }}" type="number" min="1" readonly>
            </div>

            <div class="mb-3">
                <label><b>Status</b> <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="status" disabled>
                    <option value="" disabled>Choose Status</option>
                    <option value="process" {{ $booking->status == 'process' ? 'selected' : '' }}>Process</option>
                    <option value="success" {{ $booking->status == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="abort" {{ $booking->status == 'abort' ? 'selected' : '' }}>Abort</option>
                </select>
                <input type="hidden" name="status" value="{{ $booking->status }}">
            </div>

            <div class="mb-3">
                <label><b>Room Status</b> <span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="status_room" required>
                    <option value="" disabled>Choose Status</option>
                    <option value="occupied" {{ $booking->status_room == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="empty" {{ $booking->status_room == 'empty' ? 'selected' : '' }}>Empty</option>
                </select>
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection
