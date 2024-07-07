<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{

    public function index(){
        $room = Room::with('homestay')->latest()->get();

        $result = $room->map(function ($data){
            return [
                'id' => $data->id,
                'homestays_id' => $data->homestays_id,
                'homestay_name' => $data->homestay->name,
                'type' => $data->type,
                'description' => $data->description,
                'quota' => $data->quota,
                'price' => $data->formatted_price,
                'picture' => $data->images,
            ];
        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result' => $result], 200);
    }


}
