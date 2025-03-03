@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Add New Review</h1>
    
    <form action="{{ route('admin.review_store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="room_id">Room ID</label>
            <input type="number" name="room_id" class="form-control @error('room_id') is-invalid @enderror" value="{{ old('room_id') }}">
            @error('room_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="customer_id">Customer ID</label>
            <input type="number" name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" value="{{ old('customer_id') }}">
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror" value="{{ old('rating') }}" min="1" max="5">
            @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" class="form-control @error('review') is-invalid @enderror" rows="5">{{ old('review') }}</textarea>
            @error('review')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Review</button>
    </form>
</div>
@endsection
