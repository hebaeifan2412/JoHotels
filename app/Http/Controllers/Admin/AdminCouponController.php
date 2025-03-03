<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Hotel;


class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->with('hotel')->paginate(10);

        return view('admin.coupon_view', compact('coupons'));
    }


    public function create()
    {
        $hotels = Hotel::all(); 
        $coupon = null; 

        return view('admin.coupon_create', compact('hotels', 'coupon'));
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

    return redirect()->route('admin.coupon_index')->with('success', 'Coupon created successfully!');
}


public function edit($id)
{
    $coupon = Coupon::findOrFail($id); 
    $hotels = Hotel::all(); 
    return view('admin.coupon_edit', compact('coupon', 'hotels'));
}


public function update(Request $request, $id)
{
    $coupon = Coupon::findOrFail($id);
    $request->validate([
        'code' => 'required|unique:coupons,code,' . $coupon->id,
        'discount_amount' => 'required|numeric|min:0',
        'discount_type' => 'required|in:fixed,percentage',
        'hotel_id' => 'nullable|exists:hotels,id',
        'status' => 'required|boolean',
    ]);

    $coupon->update($request->all());
    return redirect()->route('admin.coupon_index')->with('success', 'Coupon updated successfully!');
}


public function destroy(Coupon $coupon)
{
    $coupon->delete();

    return redirect()->route('admin.coupon_index')->with('success', 'Coupon deleted successfully!');
}


}