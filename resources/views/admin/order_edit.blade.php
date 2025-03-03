@extends('admin.layout.app')

@section('heading', 'Edit Order')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="order_no">Order No</label>
                            <input type="text" name="order_no" class="form-control" value="{{ $order->order_no }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <input type="text" name="payment_method" class="form-control" value="{{ $order->payment_method }}" required>
                        </div>
                        <div class="form-group">
                            <label for="booking_date">Booking Date</label>
                            <input type="text" name="booking_date" class="form-control" value="{{ $order->booking_date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="paid_amount">Paid Amount</label>
                            <input type="text" name="paid_amount" class="form-control" value="{{ $order->paid_amount }}" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select name="customer_id" class="form-control" required>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $customer->id == $order->customer_id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
