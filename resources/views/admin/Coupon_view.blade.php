@extends('admin.layout.app')

@section('heading', 'Manage Coupons')

@section('right_top_button')
<a href="{{ route('admin.coupon_create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Coupon</a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Coupon Code</th>
                                    <th>Discount Amount</th>
                                    <th>Discount Type</th>
                                    <th>Hotel</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_amount }}</td>
                                    <td>{{ ucfirst($coupon->discount_type) }}</td>
                                    <td>
                                        {{ $coupon->hotel ? $coupon->hotel->name : 'No Hotel' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $coupon->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $coupon->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin.coupon_edit', $coupon->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.coupon_delete', $coupon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
