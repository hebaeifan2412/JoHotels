@extends('admin.layout.app')

@section('heading', 'Add New Customer')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customer_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Country -->
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" class="form-control" value="{{ old('country') }}">
                            @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Photo -->
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" id="photo" name="photo" class="form-control">
                            @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
