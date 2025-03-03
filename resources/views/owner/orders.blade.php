@extends('owner.layout.app')

@section('heading', 'Orders')

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
                                    <th>Order ID</th>
                                    <th>Hotel Name</th>
                                    <th>Room Name(s)</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->orderDetails->first()->room->hotel->name ?? 'N/A' }}</td>
                                        <td>
                                            @foreach($order->orderDetails as $detail)
                                                {{ $detail->room->name }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $order->orderDetails->first()->checkin_date ?? 'N/A' }}</td>
                                        <td>{{ $order->orderDetails->first()->checkout_date ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('owner.invoice', $order->id) }}">View Invoice</a>
                                            <form action="{{ route('owner.order.delete', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection