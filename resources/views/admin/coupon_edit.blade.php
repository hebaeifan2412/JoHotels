@extends('admin.layout.app')

@section('heading', 'Edit Coupon')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.coupon_update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <!-- Display validation errors -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    
                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}" required>
                        </div>
                    
                        <!-- Discount Amount -->
                        <div class="mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount', $coupon->discount_amount) }}" required>
                        </div>
                    
                        <!-- Discount Type -->
                        <div class="mb-3">
                            <label class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-control">
                                <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    {{-- hotel --}}
                    <div class="mb-3">
                        <label class="form-label">Hotel</label>
                        <select name="hotel_id" class="form-control">
                            <option value="">Select a hotel</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}" 
                                    {{ old('hotel_id', $coupon->hotel_id) == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                        
                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.coupon_index') }}" class="btn btn-secondary">Back</a>
                    </form>
                    
@endsection
