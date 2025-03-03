@extends('admin.layout.app')

@section('heading', 'Customers')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.customer_create') }}" class="btn btn-primary mb-3">Add New Customer</a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($row->photo)
                                            <img src="{{ asset('uploads/'.$row->photo) }}" width="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('uploads/default.png') }}" width="50" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone ?? 'N/A' }}</td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin.customer_edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('admin.customer_destroy', $row->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
