@extends('admin.layout.app')

@section('heading', 'Add Room')

@section('right_top_button')
<a href="{{ route('admin_room_view') }}" class="btn btn-primary"><i class="fa fa-eye"></i> View All</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin_room_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Room Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Price *</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Rooms *</label>
                                    <input type="text" class="form-control" name="total_rooms" value="{{ old('total_rooms') }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Select Hotel *</label>
                                    <select class="form-control" name="hotel_id" required>
                                        <option value="">Select Hotel</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Amenities</label>
                                    <select class="form-control" name="arr_amenities[]" multiple>
                                        @foreach($all_amenities as $amenity)
                                            <option value="{{ $amenity->id }}" 
                                                {{ in_array($amenity->id, old('arr_amenities', [])) ? 'selected' : '' }}>
                                                {{ $amenity->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Size</label>
                                    <input type="text" class="form-control" name="size" value="{{ old('size') }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Beds</label>
                                    <input type="text" class="form-control" name="total_beds" value="{{ old('total_beds') }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Bathrooms</label>
                                    <input type="text" class="form-control" name="total_bathrooms" value="{{ old('total_bathrooms') }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Balconies</label>
                                    <input type="text" class="form-control" name="total_balconies" value="{{ old('total_balconies') }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Total Guests</label>
                                    <input type="text" class="form-control" name="total_guests" value="{{ old('total_guests') }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Featured Photo *</label>
                                    <input type="file" class="form-control" name="featured_photo" required>
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
