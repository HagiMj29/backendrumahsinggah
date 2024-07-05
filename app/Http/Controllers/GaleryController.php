<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class GaleryController extends Controller
{
    public function index(){
        $galery = Galery::all(); // Mengambil semua data galeri dari database

        return view('galery.index',['galery'=>$galery]);
    }

    public function create(){
        return view('galery.create');
    }

    public function store(Request $request){

        $validateData = $request->validate([
            'picture'=>'required'
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validateData['picture'] = $filename;
        }

        if (Galery::create($validateData)) {
            return redirect()->route('galery.index')->with('success', 'Data Successfully added');
        } else {
            return redirect()->back()->with('error', 'Data Failed to add');
        }
        
    }

    public function edit(Galery $galery){
        return view('galery.edit',['galery'=>$galery]);
    }


    public function update(Request $request, Galery $galery){

        $validateData = $request->validate([
            'picture'=>'required'
        ]);

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($galery->picture && file_exists(public_path('images/' . $galery->picture))) {
                unlink(public_path('images/' . $galery->picture));
            }
    
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validateData['picture'] = $filename;
        }
    
        try {
            $galery->update($validateData);
            return redirect()->route('galery.index')->with('success', 'Data successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data failed to update: ' . $e->getMessage());
        }
        
    }


    public function destroy(Galery $galery)
{
    if ($galery->delete()) {
        return redirect()->route('galery.index')->with('success', 'Data Successfully deleted');
    } else {
        return redirect()->back()->with('error', 'Data Failed to delete');
    }
}



}
