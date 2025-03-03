<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class OwnerProfileController extends Controller
{
    public function index()
    {
        return view('owner.profile');
    }

    public function profile_submit(Request $request)
    {
        $owner_data = Owner::where('email',Auth::guard('owner')->user()->email)->first();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($request->password!='') {
            $request->validate([
                'password' => 'required',
                'retype_password' => 'required|same:password'
            ]);
            $owner_data->password = Hash::make($request->password);
        }

        if($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            unlink(public_path('uploads/'.$owner_data->photo));

            $ext = $request->file('photo')->extension();
            $final_name = 'owner'.'.'.$ext;

            $request->file('photo')->move(public_path('uploads/'),$final_name);

            $owner_data->photo = $final_name;
        }

        
        $owner_data->name = $request->name;
        $owner_data->email = $request->email;
        $owner_data->update();

        return redirect()->back()->with('success', 'Profile information is saved successfully.');
    }
}
