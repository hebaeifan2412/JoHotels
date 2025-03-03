@extends('admin.layout.app')

@section('heading', 'Hotels')

@section('right_top_button')
<a href="{{ route('admin.hotel_create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Hotel</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hotel Name</th>
                                        <th>Owner</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hotels as $hotel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $hotel->name }}</td>
                                        <td>{{ $hotel->owner->name ?? 'No Owner' }}</td>
                                        <td>{{ $hotel->description ?? 'No Description' }}</td>
                                        <td>{{ $hotel->location ?? 'No Location' }}</td>
                                        <td>
                                    <a href="{{ route('admin.hotel_edit', $hotel->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.hotel_destroy', $hotel->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
