<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Owner;
use Illuminate\Http\Request;

class AdminHotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('owner')->get();
        return view('admin.hotel_view', compact('hotels')); 
    }

    public function create()
    {
        $owners = Owner::all(); 
        return view('admin.hotel_create', compact('owners'));
       }

       public function store(Request $request)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'location' => 'required|string|max:255',
               'owner_id' => 'required|exists:owners,id',
               'description' => 'nullable|string',
           ]);
       
           Hotel::create([
               'name' => $request->name,
               'description' => $request->description,
               'location' => $request->location,
               'owner_id' => $request->owner_id,
           ]);
       
           return redirect()->route('admin.hotel_view')->with('success', 'Hotel added successfully.');
       }
       
       public function edit($id)
       {
           $hotel = Hotel::findOrFail($id);
           $owners = Owner::all(); 
       
           return view('admin.hotel_edit', compact('hotel', 'owners'));
       }
       

       public function update(Request $request, $id)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'location' => 'required|string|max:255',
               'owner_id' => 'required|exists:owners,id',
               'description' => 'nullable|string',
           ]);
       
           $hotel = Hotel::findOrFail($id);
           $hotel->update([
               'name' => $request->name,
               'description' => $request->description,
               'location' => $request->location,
               'owner_id' => $request->owner_id,
           ]);
       
           return redirect()->route('admin.hotel_view')->with('success', 'Hotel updated successfully.');
       }
           public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->delete();

        return redirect()->route('admin.hotel_view')->with('success', 'Hotel deleted successfully.');
    }
}
