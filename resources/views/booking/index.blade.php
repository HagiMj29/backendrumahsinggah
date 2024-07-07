@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Booking
    </div>
    <div class="card-body">
        <div class="panel-body mb-3">
            <a href="{{route('booking.create')}}" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>
            <form action="{{ route('booking.index') }}" method="GET" class="form-inline">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name and Address" value="{{ request()->input('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive w-100">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Homestays</th>
                    <th class="text-center">Room</th>
                    <th class="text-center">Day</th>
                    <th class="text-center">Total Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Room Status</th>
                    <th class="text-center">Aksi</th>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($booking as $data)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $data->user->name }}</td>
                            <td class="text-center">{{ $data->homestay->name }}</td>
                            <td class="text-center">{{ $data->room->type }}</td>
                            <td class="text-center">{{ $data->day }}</td>
                            <td class="text-center">{{ $data->formatted_price }}</td>
                            <td class="text-center">{{ $data->status }}</td>
                            <td class="text-center">{{ $data->status_room }}</td>
                            <td class="text-center">
                                <a href="{{route('booking.edit',['booking'=>$data->id])}}" class="btn btn-warning btn-circle">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="{{route('booking.checkout_page',['booking'=>$data->id])}}" class="btn btn-info btn-circle">
                                    <i class="fas fa fa-caret-square-o-down"></i>
                                </a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{route('booking.destroy', ['booking'=>$data->id])}}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
