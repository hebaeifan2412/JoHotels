@extends('owner.layout.app')

@section('heading', 'Dashboard')

@section('main_content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fa fa-cart-plus"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Completed Orders</h4>
                </div>
                <div class="card-body">
                    {{ $total_completed_orders }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pending Orders</h4>
                </div>
                <div class="card-body">
                    {{ $total_pending_orders }}
                </div>
            </div>
        </div>
    </div>
   
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fa fa-home"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Rooms</h4>
                </div>
                <div class="card-body">
                    {{ $total_rooms }}
                </div>
            </div>
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-md-12">
   <div class="section-body">
 
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Recent Orders</h1>
            </div>
        </section>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
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
                                            
                                            <form action="{{ route('owner.order.delete', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
    </div>
</div>


@endsection