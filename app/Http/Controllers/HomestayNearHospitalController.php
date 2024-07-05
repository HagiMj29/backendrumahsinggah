<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Models\HomestayNearHospital;

class HomestayNearHospitalController extends Controller
{
    public function index(Request $request){
        $query = HomestayNearHospital::query();
    
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('hospital', 'LIKE', "%{$search}%");
            });
        }
    
        $homestayhospital = $query->latest()->get();
        $title = "Homestay Near Hospital";
    
        return view('homestayhospital.index', ['homestayhospital' => $homestayhospital, 'listtitle' => $title, 'search' => $request->input('search')]);
    }


    public function create(){
        $homestays = Homestay::all();
        return view('homestayhospital.create',['homestays'=>$homestays]);
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'hospital'=>'required',
            'homestays_id'=>'required',
            'google_maps'=>'required',
        ]);

        if (HomestayNearHospital::create($validateData)) {
            return redirect()->route('homestayhospital.index')->with('success', 'Data Successfully added');
        } else {
            return redirect()->back()->with('error', 'Data Failed to add');
        }
    }

    public function edit(HomestayNearHospital $homestayhospital){
        $homestays = Homestay::all();
        return view('homestayhospital.edit',['homestayhospital' => $homestayhospital,'homestays'=>$homestays]);
    }

    public function update(Request $request,HomestayNearHospital $homestayhospital){
        $validateData = $request->validate([
            'hospital'=>'required',
            'homestays_id'=>'required',
            'google_maps'=>'required',
        ]);

        if ($homestayhospital->update($validateData)) {
            return redirect()->route('homestayhospital.index')->with('success', 'Data Successfully updated');
        } else {
            return redirect()->back()->with('error', 'Data Failed to update');
        }
    }

    public function destroy(HomestayNearHospital $homestayhospital)
    {
        if ($homestayhospital->delete()) {
            return redirect()->route('homestayhospital.index')->with('success', 'Data successfully deleted');
        } else {
            return redirect()->back()->with('error', 'Data failed to delete');
        }
    }


}
