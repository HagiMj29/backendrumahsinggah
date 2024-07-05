<?php

namespace App\Http\Controllers\API;

use App\Models\Galery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\ValidatedData;

class GaleryController extends Controller
{
    public function index(){
        
        $galery = Galery::latest()->get();
    
        $result = $galery->map(function ($data){
            return [
                'id' => $data->id,
                'picture' => $data->picture,
            ];
        });
    
        return response()->json(['message' => 'Data Berhasil di Akses', 'result' => $result], 200);
    }



}
