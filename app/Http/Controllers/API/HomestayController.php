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



}
