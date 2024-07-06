<?php

namespace App\Http\Controllers\API;

use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HomestayNearHospital;

class HomestayNearHospitalController extends Controller
{
    public function index(){
        $homestayhospital = HomestayNearHospital::latest()->get();

        $result = $homestayhospital->map(function ($data){

            return [
                'id'=>$data->id,
                'hospital'=>$data->hospital,
                'homestays_id'=>$data->homestay->id,
                'homestay_name'=>$data->homestay->name,
                'homestay_picture'=>$data->homestay->picture,
                'homestay_address'=>$data->homestay->address,
                'google_maps'=>$data->google_maps,
            ];

        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result'=>$result], 200);

    }





}
