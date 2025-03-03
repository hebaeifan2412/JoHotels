<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    
    
    public function index()
    {
        $customers = Customer::paginate(10); 
        return view('admin.customer_view', compact('customers')); 
    }
    
    public function create()
    {
        return view('admin.customer_create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6', 
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
    
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads', 'public');
        }
    
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'country' => $request->country,
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('admin.customer_view')->with('success', 'Customer added successfully.');
    }
    
    
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer_edit', compact('customer'));
    }

    public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email,' . $customer->id,
        'password' => 'nullable|min:6', 
        'phone' => 'nullable|string',
        'country' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    if ($request->hasFile('photo')) {
        if ($customer->photo) {
            unlink(public_path('storage/' . $customer->photo));
        }
        $customer->photo = $request->file('photo')->store('customers', 'public');
    }

    if ($request->password) {
        $customer->password = Hash::make($request->password); 
    }

    $customer->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'country' => $request->country,
    ]);

    return redirect()->route('admin.customer_view')->with('success', 'Customer updated successfully.');
}

    public function destroy($id)
    {
        $customer = Customer::find($id);
        
        if ($customer) {
            if ($customer->photo && file_exists(public_path('storage/uploads/'.$customer->photo))) {
                unlink(public_path('storage/uploads/'.$customer->photo));
            }
    
            $customer->delete();
    
            return redirect()->route('admin.customer_view')->with('success', 'Customer deleted successfully.');
        }
    
        return redirect()->route('admin.customer_view')->with('error', 'Customer not found.');
    }
    
}
