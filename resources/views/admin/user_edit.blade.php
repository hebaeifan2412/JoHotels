@extends('admin.layout.app')

@section('heading', 'Edit User')

@section('main_content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Edit User</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password (Leave empty to keep current password)</label>
                    <input type="password" id="password" name="password" class="form-control">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('admin.user_view') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
