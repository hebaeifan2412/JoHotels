<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomPhoto;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class OwnerRoomController extends Controller
{
    public function index()
    {
        $owner_id = Auth::id(); 
        $hotels = Hotel::where('owner_id', $owner_id)->get();

        $rooms = Room::whereHas('hotel', function ($query) use ($owner_id) {
            $query->where('owner_id', $owner_id);
        })->get();

        return view('owner.room.room_view', compact('rooms','hotels'));
    }

    public function add()
    {
        $owner_id = Auth::id();
        $hotels = Hotel::where('owner_id', $owner_id)->get();
        $all_amenities = Amenity::get();

        return view('owner.room.add', compact('all_amenities', 'hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'featured_photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        // Ensure the hotel belongs to the logged-in owner
        $hotel = Hotel::where('id', $request->hotel_id)
                      ->where('owner_id', Auth::id())
                      ->firstOrFail();

        // Process the amenities
        $amenities = $request->arr_amenities ? implode(',', $request->arr_amenities) : '';

        // Process the featured photo
        $ext = $request->file('featured_photo')->extension();
        $final_name = time() . '.' . $ext;
        $request->file('featured_photo')->move(public_path('uploads/'), $final_name);

        // Create the room
        Room::create([
            'hotel_id' => $hotel->id,
            'featured_photo' => $final_name,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'amenities' => $amenities,
            'size' => $request->size ?? null,
            'total_beds' => $request->total_beds ?? null,
            'total_bathrooms' => $request->total_bathrooms ?? null,
            'total_balconies' => $request->total_balconies ?? null,
            'total_guests' => $request->total_guests ?? null,
            'video_id' => $request->video_id ?? null,
        ]);

        return redirect()->back()->with('success', 'Room added successfully.');
    }

    public function edit($id)
    {
        $owner_id = Auth::id();
        $hotels = Hotel::where('owner_id', $owner_id)->get();

        $room = Room::where('id', $id)
            ->whereHas('hotel', function ($query) use ($owner_id) {
                $query->where('owner_id', $owner_id);
            })
            ->firstOrFail();

        $all_amenities = Amenity::all();
        $existing_amenities = $room->amenities ? explode(',', $room->amenities) : [];

        return view('owner.room.room_edit', compact('room', 'all_amenities', 'existing_amenities', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        // Ensure the room belongs to the logged-in user (owner)
        $room = Room::where('id', $id)
            ->whereHas('hotel', function ($query) {
                $query->where('owner_id', Auth::id());
            })
            ->firstOrFail();
    
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'featured_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        // Process amenities
        $amenities = $request->arr_amenities ? implode(',', $request->arr_amenities) : '';
    
        // Handle featured photo upload
        if ($request->hasFile('featured_photo')) {
            // Delete the old photo if it exists
            $old_photo_path = public_path('uploads/' . $room->featured_photo);
            if (file_exists($old_photo_path) && !is_dir($old_photo_path)) {
                unlink($old_photo_path);
            }
    
            // Upload new photo
            $ext = $request->file('featured_photo')->extension();
            $final_name = time() . '.' . $ext;
            $request->file('featured_photo')->move(public_path('uploads/'), $final_name);
    
            $room->featured_photo = $final_name;
        }
    
        // Update room details
        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'amenities' => $amenities,
            'size' => $request->size ?? null,
            'total_beds' => $request->total_beds ?? null,
            'total_bathrooms' => $request->total_bathrooms ?? null,
            'total_balconies' => $request->total_balconies ?? null,
            'total_guests' => $request->total_guests ?? null,
            'video_id' => $request->video_id ?? null,
        ]);
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Room updated successfully.');
    }
    

    public function delete($id)
    {
        $room = Room::where('id', $id)->whereHas('hotel', function ($query) {
            $query->where('owner_id', Auth::id());
        })->firstOrFail();

        unlink(public_path('uploads/' . $room->featured_photo));
        $room->delete();

        $room_photos = RoomPhoto::where('room_id', $id)->get();
        foreach ($room_photos as $photo) {
            unlink(public_path('uploads/' . $photo->photo));
            $photo->delete();
        }

        return redirect()->back()->with('success', 'Room deleted successfully.');
    }
}
