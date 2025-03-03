<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;

class OwnerAuthController extends Controller
{
    public function login()
    {
        $global_page_data = Page::first(); // Fetch page settings
        return view('owner.login', compact('global_page_data'));
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('owner')->attempt($credential)) {
            return redirect()->route('owner_home'); // Redirect to home page after login success
        } else {
            return redirect()->route('owner_login')->with('error', 'Information is not correct!');
        }
    }

    public function signup()
    {
        $global_page_data = Page::first(); // Fetch page settings
        return view('front.signup', compact('global_page_data'));
    }

    public function signup_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:owners',
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        $password = Hash::make($request->password);

        $owner = new Owner();
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = $password;
        
        $owner->save();

        return redirect()->route('owner_login')->with('success', 'Your account has been created successfully!');
    }

    public function logout()
    {
        Auth::guard('owner')->logout();

        // 🔹 Clear session data on logout
        session()->forget('discount_amount');
        session()->forget('final_total');
        session()->forget('applied_coupon');

        return redirect()->route('owner_login')->with('success', 'You have been logged out.');
    }
}
