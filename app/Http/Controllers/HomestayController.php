<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    public function index(Request $request){

        $query = Homestay::query();
    
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }
    
        $homestay = $query->latest()->get();
        $title = "Homestay";
    
        return view('homestay.index', ['homestay' => $homestay, 'listtitle' => $title, 'search' => $request->input('search')]);
        
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
