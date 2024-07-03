<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Homestay;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
{
    $query = Room::query();
    
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->whereHas('homestay', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhere('type', 'LIKE', "%{$search}%");
        });
    }
    
    $room = $query->latest()->get();
    $title = "Room";
    
    return view('room.index', ['room' => $room, 'listtitle' => $title, 'search' => $request->input('search')]);
}


    public function create(){
        $homestays = Homestay::all();
        return view('room.create',['homestays'=>$homestays]);
    }

    public function store(Request $request)
{
    $validateData = $request->validate([
        'homestays_id' => 'required',
        'type' => 'required',
        'description' => 'required',
        'quota' => 'required',
        'price' => 'required',
        'pictures.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Create the Room
    $room = Room::create($validateData);

    // Handle file upload
    if ($request->hasFile('pictures')) {
        foreach ($request->file('pictures') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $room->images()->create([
                'filename' => $filename
            ]);
        }
    }

    if ($room) {
        return redirect()->route('room.index')->with('success', 'Data Successfully added');
    } else {
        return redirect()->back()->with('error', 'Data Failed to add');
    }
}




    public function edit(Room $room){
        $homestays = Homestay::all();
        return view('room.edit',['room'=>$room,'homestays'=>$homestays]);
    }


    public function update(Request $request, Room $room){

        $validateData = $request->validate([
            'homestays_id'=>'required',
            'type'=>'required',
            'description'=>'required',
            'quota'=>'required',
            'price'=>'required',
            'picture' => 'nullale|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

         // Handle file upload
    if ($request->hasFile('picture')) {
        // Delete old picture if exists
        if ($room->picture && file_exists(public_path('images/' . $room->picture))) {
            unlink(public_path('images/' . $room->picture));
        }

        $file = $request->file('picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $validateData['picture'] = $filename;
    }

    try {
        $room->update($validateData);
        return redirect()->route('room.index')->with('success', 'Data successfully updated');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Data failed to update: ' . $e->getMessage());
    }
    }


    public function destroy(Room $room)
    {
        if ($room->delete()) {
            return redirect()->route('room.index')->with('success', 'Data Successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Data Failed to delete');
        }
    }




}
