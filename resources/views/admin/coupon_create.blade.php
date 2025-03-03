@extends('admin.layout.app')

@section('heading', 'Add New Coupon')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.coupon_store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-control" required>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hotel</label>
                            <select name="hotel_id" class="form-control">
                                <option value="">Select a hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" 
                                        {{ old('hotel_id', $coupon->hotel_id ?? '') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                        <a href="{{ route('admin.coupon_index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
