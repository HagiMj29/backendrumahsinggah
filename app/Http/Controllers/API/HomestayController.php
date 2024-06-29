<?php

namespace App\Http\Controllers\API;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomestayController extends Controller
{
    public function index(Request $request){

        $homestay = Homestay::latest()->get();

        $result = $homestay->map(function ($data){
            
            return [
                'id'=>$data->id,
                'name'=>$data->name,
                'address'=>$data->address,
                'picture'=>$data->picture,
            ];

        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result'=>$result], 200);
        
    }


    public function create(){
        return view('homestay.create');
    }

    public function store(Request $request)
    {
    $validateData = $request->validate([
        'name' => 'required',
        'address' => 'required',
        'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $validateData['picture'] = $filename;
    }


    if (Homestay::create($validateData)) {
        return redirect()->route('homestay.index')->with('success', 'Data Successfully added');
    } else {
        return redirect()->back()->with('error', 'Data Failed to add');
    }
    }

    public function edit(Homestay $homestay){
        
        return view('homestay.edit',['homestay'=>$homestay]);

    }

    public function update(Request $request, Homestay $homestay)
{
    $validateData = $request->validate([
        'name' => 'required',
        'address' => 'required',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('picture')) {
        // Delete old picture if exists
        if ($homestay->picture && file_exists(public_path('images/' . $homestay->picture))) {
            unlink(public_path('images/' . $homestay->picture));
        }

        $file = $request->file('picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $validateData['picture'] = $filename;
    }

    try {
        $homestay->update($validateData);
        return redirect()->route('homestay.index')->with('success', 'Data successfully updated');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Data failed to update: ' . $e->getMessage());
    }
}

public function destroy(Homestay $homestay)
    {
        if ($homestay->delete()) {
            return redirect()->route('homestay.index')->with('success', 'Data Successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Data Failed to delete');
        }
    }



}
