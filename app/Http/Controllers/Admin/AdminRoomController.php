<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomPhoto;
use App\Models\Hotel;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')->get(); 
        return view('admin.room_view', compact('rooms'));
    }

    public function add()
    {
        $all_amenities = Amenity::get();
        $hotels = Hotel::all(); 
        return view('admin.room_add', compact('all_amenities', 'hotels'));
    }

    public function store(Request $request)
    {
        $amenities = '';
        $i = 0;

        if (isset($request->arr_amenities)) {
            foreach ($request->arr_amenities as $item) {
                if ($i == 0) {
                    $amenities .= $item;
                } else {
                    $amenities .= ',' . $item;
                }
                $i++;
            }
        }

        $request->validate([
            'hotel_id' => 'required',  
            'featured_photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'total_rooms' => 'required',
        ]);

        $ext = $request->file('featured_photo')->extension();
        $final_name = time() . '.' . $ext;
        $request->file('featured_photo')->move(public_path('uploads/'), $final_name);

        $obj = new Room();
        $obj->featured_photo = $final_name;
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->price = $request->price;
        $obj->amenities = $amenities;
        $obj->size = $request->size;
        $obj->total_beds = $request->total_beds;
        $obj->total_bathrooms = $request->total_bathrooms;
        $obj->total_balconies = $request->total_balconies;
        $obj->total_guests = $request->total_guests;
        $obj->video_id = $request->video_id;
        $obj->hotel_id = $request->hotel_id;  
        $obj->save();

        return redirect()->back()->with('success', 'Room is added successfully.');
    }

    public function edit($id)
    {
        $room = Room::find($id); 
    
        if (!$room) {
            return redirect()->route('admin_rooms_list')->with('error', 'Room not found.');
        }
    
        $all_amenities = Amenity::get();
        $hotels = Hotel::all();
    
        $existing_amenities = [];
        if ($room->amenities != '') {
            $existing_amenities = explode(',', $room->amenities);
        }
    
        return view('admin.room_edit', compact('room', 'all_amenities', 'existing_amenities', 'hotels'));
    }
    
    
    public function update(Request $request, $id)
    {
        $obj = Room::where('id', $id)->first();
    
        if ($request->hasFile('featured_photo')) {
            $request->validate([
                'featured_photo' => 'image|mimes:jpg,jpeg,png,gif'
            ]);
    
            if (!empty($obj->featured_photo) && file_exists(public_path('uploads/' . $obj->featured_photo))) {
                unlink(public_path('uploads/' . $obj->featured_photo));
            }
    
            $ext = $request->file('featured_photo')->extension();
            $final_name = time() . '.' . $ext;
            $request->file('featured_photo')->move(public_path('uploads/'), $final_name);
            
            $obj->featured_photo = $final_name;
        }
    
        $amenities = $request->arr_amenities ? implode(',', $request->arr_amenities) : '';
    
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->price = $request->price;
        $obj->amenities = $amenities; 
        $obj->size = $request->size;
        $obj->total_beds = $request->total_beds;
        $obj->total_bathrooms = $request->total_bathrooms;
        $obj->total_balconies = $request->total_balconies;
        $obj->total_guests = $request->total_guests;
        $obj->video_id = $request->video_id;
        $obj->hotel_id = $request->hotel_id;
        $obj->update();
    
        return redirect()->back()->with('success', 'Room is updated successfully.');
    }
    

    public function delete($id)
    {
        $room = Room::findOrFail($id);
    
        if (!empty($room->featured_photo) && file_exists(public_path('uploads/' . $room->featured_photo))) {
            unlink(public_path('uploads/' . $room->featured_photo));
        }
    
        $room->delete();
    
        return redirect()->route('admin_rooms_list')->with('success', 'Room deleted successfully.');
    }
    
    public function gallery($id)
    {
        $room_data = Room::where('id', $id)->first();
        $room_photos = RoomPhoto::where('room_id', $id)->get();
        return view('admin.room_gallery', compact('room_data', 'room_photos'));
    }

    public function gallery_store(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        $ext = $request->file('photo')->extension();
        $final_name = time() . '.' . $ext;
        $request->file('photo')->move(public_path('uploads/'), $final_name);

        $obj = new RoomPhoto();
        $obj->photo = $final_name;
        $obj->room_id = $id;
        $obj->save();

        return redirect()->back()->with('success', 'Photo is added successfully.');
    }

    public function gallery_delete($id)
    {
        $single_data = RoomPhoto::where('id', $id)->first();
        unlink(public_path('uploads/' . $single_data->photo));
        $single_data->delete();

        return redirect()->back()->with('success', 'Photo is deleted successfully.');
    }
}
