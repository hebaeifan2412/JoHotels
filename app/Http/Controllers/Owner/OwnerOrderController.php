<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Room;

class OwnerOrderController extends Controller
{
    /**
     * Display a list of orders for the owner's hotels.
     */
    public function index()
    {
        $ownerId = Auth::id(); // Get the authenticated owner's ID

        // Fetch only orders containing rooms from hotels owned by the authenticated owner
        $orders = Order::whereHas('orderDetails.room.hotel', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->with(['orderDetails.room.hotel'])->get();

        return view('owner.orders', compact('orders'));
    }

  
    public function invoice($id)
    {
        $ownerId = Auth::id(); // Get the authenticated owner's ID

        // Fetch the order only if it belongs to a hotel owned by the authenticated owner
        $order = Order::whereHas('orderDetails.room.hotel', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->with(['orderDetails.room.hotel', 'customer'])->findOrFail($id);

        return view('owner.invoice', compact('order'));
    }

   
    public function delete($id)
    {
        $ownerId = Auth::id(); // Get the authenticated owner's ID

        // Ensure the order belongs to the owner's hotel before deleting
        $order = Order::whereHas('orderDetails.room.hotel', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->findOrFail($id);

        // Delete order details first, then the order itself
        OrderDetail::where('order_id', $id)->delete();
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully');
    }
}
