@extends('admin.layout.app')

@section('heading', 'Edit Review')

@section('right_top_button')
<a href="{{ route('admin.review_view') }}" class="btn btn-primary"><i class="fa fa-eye"></i> View All</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.review_update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                {{-- <div class="mb-4">
                                    <label class="form-label">Room ID *</label>
                                    <input type="number" class="form-control" name="room_id" value="{{ old('room_id', $review->room_id) }}" required>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Customer ID *</label>
                                    <input type="number" class="form-control" name="customer_id" value="{{ old('customer_id', $review->customer_id) }}" required>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="mb-4">
                                    <label class="form-label">Rating *</label>
                                    <input type="number" class="form-control" name="rating" value="{{ old('rating', $review->rating) }}" min="1" max="5" required>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Review *</label>
                                    <textarea name="review" class="form-control" rows="5" required>{{ old('review', $review->review) }}</textarea>
                                    @error('review')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Update Review</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
