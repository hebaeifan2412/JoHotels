<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;

class AdminOrderController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); 
        $orders = Order::get();  
        
        return view('admin.orders', compact('orders', 'customers'));
    }
    
    public function invoice($id)
    {
        $order = Order::with('orderDetails')->where('id', $id)->first();
        
        if (!$order || $order->orderDetails->isEmpty()) {
            return redirect()->back()->with('error', 'No details found for this order!');
        }
    
        $customer_data = Customer::where('id', $order->customer_id)->first();
    
        return view('admin.invoice', compact('order', 'customer_data'));
    }


    public function edit($id)
    {
        $order = Order::findOrFail($id); 
        $customers = Customer::all();   
        return view('admin.order_edit', compact('order', 'customers')); 
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_no' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'paid_amount' => 'required|numeric',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $order->update([
            'order_no' => $request->order_no,
            'payment_method' => $request->payment_method,
            'booking_date' => $request->booking_date,
            'paid_amount' => $request->paid_amount,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->route('admin.order_index')->with('success', 'Order updated successfully!');
    }


    

    public function delete($id)
    {
        Order::where('id', $id)->delete();
        OrderDetail::where('order_id', $id)->delete();

        return redirect()->back()->with('success', 'Order is deleted successfully');
    }
}
