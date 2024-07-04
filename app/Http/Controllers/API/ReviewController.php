<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Review;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $review = Review::latest()->get();
    
        $result = $review->map(function ($data){
            return [
                'id' => $data->id,
                'user_id' => $data->user_id,
                'homestays_id' => $data->homestays_id, 
                'homestay_name' => $data->homestay->name, 
                'rating' => $data->rating,
                'review' => $data->review,
            ];
        });
    
        return response()->json(['message' => 'Data Berhasil di Akses', 'result' => $result], 200);
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
            'rating' => 'required',
            'review' => 'required',
        ]);

        $result = $validateData;


        if (Review::create($validateData)) {
            return response()->json(['message' => 'Data success to create', 'result' => $result], 200);
        } else {
            return response()->json(['message' => 'Data failed to create'], 500);
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
            return redirect()->route('review.index')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data');
        }
    }

    public function destroy(Review $review)
{
    if ($review->delete()) {
        return redirect()->route('review.index')->with('success', 'Data Successfully deleted');
    } else {
        return redirect()->back()->with('error', 'Data Failed to delete');
    }
}


}
