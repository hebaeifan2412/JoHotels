<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['customer', 'room'])->paginate(10);
        return view('admin.review_view', compact('reviews'));
    }

    public function create()
    {
        return view('admin.review_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        Review::create([
            'room_id' => $request->room_id,
            'customer_id' => $request->customer_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('admin.review_view')->with('success', 'Review added successfully.');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.review_edit', compact('review'));
    }
    

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('admin.review_view')->with('success', 'Review updated successfully.');
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        
        if ($review) {
            $review->delete();
            return redirect()->route('admin.review_view')->with('success', 'Review deleted successfully.');
        }
    
        return redirect()->route('admin.review_view')->with('error', 'Review not found.');
    }
}
