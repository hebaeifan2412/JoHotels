<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class OwnerCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::get();
        return view('owner.customer', compact('customers'));
    }

    public function change_status($id)
    {
        $customer_data = Customer::where('id',$id)->first();
        if($customer_data->status == 1) {
            $customer_data->status = 0;
        } else {
            $customer_data->status = 1;
        }
        $customer_data->update();
        return redirect()->back()->with('success', 'Status is changed successfully.');
    }
}
