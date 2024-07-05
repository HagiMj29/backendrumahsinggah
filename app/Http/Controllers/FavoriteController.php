<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favorite;
use App\Models\Homestay;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(){
        $favorite = Favorite::all(); 
        return view('favorite.index',['favorite'=>$favorite]);
    }

    public function create(){
        $users = User::all();
        $homestays = Homestay::all();
        return view('favorite.create',['users'=>$users,'homestays'=>$homestays]);
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
        ]);

        if (Favorite::create($validateData)) {
            return redirect()->route('favorite.index')->with('success', 'Data Successfully added');
        } else {
            return redirect()->back()->with('error', 'Data Failed to add');
        }


    }

    public function edit(Favorite $favorite){
        $users = User::all();
        $homestays = Homestay::all();
        return view('favorite.edit',['favorite'=>$favorite,'users'=>$users,'homestays'=>$homestays]);
    }

    public function update(Request $request, Favorite $favorite)
    {
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
        ]);

        if ($favorite->update($validateData)) {
            return redirect()->route('favorite.index')->with('success', 'Data successfully updated');
        } else {
            return redirect()->back()->with('error', 'Data failed to update');
        }
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->delete()) {
            return redirect()->route('favorite.index')->with('success', 'Data successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Data failed to delete');
        }
    }


}
