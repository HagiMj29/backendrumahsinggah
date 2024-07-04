<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Homestay;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('homestay', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        $review = $query->latest()->get();
        $title = "Review";

        return view('review.index', ['review' => $review, 'listtitle' => $title, 'search' => $request->input('search')]);
    }

    public function create()
    {
        $users = User::all();
        $homestays = Homestay::all();
        return view('review.create', ['users' => $users, 'homestays' => $homestays]);
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
            'rating' => 'required',
            'review' => 'required',
        ]);


        if (Review::create($validateData)) {
            return redirect()->route('review.index')->with('success', 'Data Berhasil di Tambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal Menyimpan Data');
        }
    }

    public function edit(Review $review)
    {
        $users = User::all();
        $homestays = Homestay::all();
        return view('review.edit', ['review'=>$review,'users' => $users, 'homestays' => $homestays]);
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
