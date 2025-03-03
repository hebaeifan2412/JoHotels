@extends('admin.layout.app')

@section('heading', 'Edit Room')

@section('right_top_button')
<a href="{{ route('admin_room_view') }}" class="btn btn-primary"><i class="fa fa-eye"></i> View All</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin_room_update', $room->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Existing Featured Photo</label>
                                    <div>
                                        <img src="{{ asset('uploads/'.$room->featured_photo) }}" alt="" class="w_200">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Change Featured Photo</label>
                                    <div>
                                        <input type="file" name="featured_photo">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ $room->name }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Description *</label>
                                    <textarea name="description" class="form-control snote" cols="30" rows="10">{{ $room->description }}</textarea>
                                </div>
                    
                                <div class="mb-4">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price" value="{{ $room->price }}">
                                </div>
                                
                                <!-- حقل اختيار الفندق -->
                                <div class="mb-4">
                                    <label class="form-label">Hotel *</label>
                                    <select class="form-control" name="hotel_id">
                                        <option value="">Select Hotel</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" 
                                                @if($hotel->id == $room->hotel_id) selected @endif>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <div class="mb-4">
                                    <label class="form-label">Amenities</label>
                                    @php $i=0; @endphp
                                    @foreach($all_amenities as $item)
                                        @if(in_array($item->id,$existing_amenities))
                                            @php $checked_type = 'checked'; @endphp
                                        @else
                                            @php $checked_type = ''; @endphp
                                        @endif
                                        @php $i++; @endphp
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="defaultCheck{{ $i }}" name="arr_amenities[]" {{ $checked_type }}>
                                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Room Size</label>
                                    <input type="text" class="form-control" name="size" value="{{ $room->size }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Beds</label>
                                    <input type="text" class="form-control" name="total_beds" value="{{ $room->total_beds }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Bathrooms</label>
                                    <input type="text" class="form-control" name="total_bathrooms" value="{{ $room->total_bathrooms }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Balconies</label>
                                    <input type="text" class="form-control" name="total_balconies" value="{{ $room->total_balconies }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Guests</label>
                                    <input type="text" class="form-control" name="total_guests" value="{{ $room->total_guests }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Video Preview</label>
                                    <div class="iframe-container1">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $room->video_id }}" 
                                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                                        encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Video Id</label>
                                    <input type="text" class="form-control" name="video_id" value="{{ $room->video_id }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
