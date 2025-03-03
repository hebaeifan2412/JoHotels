<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Hotel;


class OwnerCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->with('hotel')->paginate(10);
    
        return view('owner.coupon.coupon_view', compact('coupons'));
    }
    
    
    public function create()
    {
        $hotels = Hotel::all(); 
        
        return view('owner.coupon.coupon_create', compact('hotels'));
    }
    
    
    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:coupons',
        'discount_amount' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percentage',
        'hotel_id' => 'nullable|exists:hotels,id',  
        'status' => 'required|boolean',
    ]);

    Coupon::create($request->all());

    return redirect()->route('owner.coupons.index')->with('success', 'Coupon created successfully!');
}

    

public function edit($id)
{
    $coupon = Coupon::findOrFail($id);
    $hotels = Hotel::all(); 
    return view('owner.coupon.coupon_edit', compact('coupon', 'hotels'));
}


public function update(Request $request, $id)
{
    $coupon = Coupon::find($id);
    $request->validate([
        'code' => 'required|unique:coupons,code,' . $coupon->id,
        'discount_amount' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percentage',
        'hotel_id' => 'nullable|exists:hotels,id',
        'status' => 'required|boolean',
    ]);

    $coupon->update($request->all());
    return redirect()->route('owner.coupon_index')->with('success', 'Coupon updated successfully!');
}


public function destroy(Coupon $coupon)
{
    $coupon->delete();

    return redirect()->route('owner.coupon_index')->with('success', 'Coupon deleted successfully!');
}

    
}
