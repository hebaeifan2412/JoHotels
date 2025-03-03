@extends('admin.layout.app')

@section('heading', 'Add New User')

@section('main_content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Create New User</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('admin.user_view') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
