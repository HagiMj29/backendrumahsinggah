@extends('layouts.main')
@section('container')

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Homestay
    </div>
    <div class="card-body">
        <div class="panel-body mb-3">
            <a href="{{route('homestay.create')}}" class="btn btn-md btn-success mb-3">TAMBAH DATA</a>
            <form action="{{ route('homestay.index') }}" method="GET" class="form-inline">
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
                    <th class="text-center">Address</th>
                    <th class="text-center">Picture</th>
                    <th class="text-center">Aksi</th>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($homestay as $data)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->address }}</td>
                            <td class="text-center">
                                @if($data->picture)
                                    <img src="{{ asset('images/' . $data->picture) }}" alt="{{ $data->name }}" style="height: 150px;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('homestay.edit',['homestay'=>$data->id])}}" class="btn btn-warning btn-circle">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{route('homestay.destroy', ['homestay'=>$data->id])}}" method="POST" style="display:inline-block;">
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
