<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Review;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
{
    $reviews = Review::latest()->get();
    
    $result = $reviews->map(function ($data){
        return [
            'id' => $data->id,
            'user_id' => $data->user_id,
            'homestays_id' => $data->homestays_id, 
            'homestay_name' => $data->homestay->name, 
            'rating' => $data->rating,
            'review' => $data->review,
        ];
    });
    
    return response()->json(['message' => 'Data accessed successfully', 'result' => $result], 200);
}

public function store(Request $request)
{
    $validateData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'homestays_id' => 'required|exists:homestays,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
    ]);

    if ($review = Review::create($validateData)) {
        return response()->json(['message' => 'Data created successfully', 'result' => $review], 201);
    } else {
        return response()->json(['message' => 'Data creation failed'], 500);
    }
}

public function update(Request $request, Review $review)
{
    $validateData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'homestays_id' => 'required|exists:homestays,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
    ]);

    if ($review->update($validateData)) {
        return response()->json(['message' => 'Data updated successfully', 'result' => $review], 200);
    } else {
        return response()->json(['message' => 'Data update failed'], 500);
    }
}

public function destroy(Review $review)
{
    if ($review->delete()) {
        return response()->json(['message' => 'Data deleted successfully'], 200);
    } else {
        return response()->json(['message' => 'Data deletion failed'], 500);
    }
}



}
