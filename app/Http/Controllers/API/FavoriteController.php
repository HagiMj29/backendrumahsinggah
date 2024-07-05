<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favorite;
use App\Models\Homestay;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(){
        $favorite = Favorite::latest()->get();
    
        $result = $favorite->map(function ($data){
            return [
                'id' => $data->id,
                'user_id' => $data->user_id,
                'name' => $data->user->name,
                'homestays_id' => $data->homestays_id, 
                'homestay_name' => $data->homestay->name, 
            ];
        });
    
        return response()->json(['message' => 'Data Berhasil di Akses', 'result' => $result], 200);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
        ]);
    
        try {
            $favorite = Favorite::create($validateData);
            return response()->json(['message' => 'Data successfully added', 'data' => $favorite], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data failed to add', 'error' => $e->getMessage()], 500);
        }
    }
    


    public function destroy(Favorite $favorite)
    {
        try {
            $favorite->delete();
            return response()->json(['message' => 'Data successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data failed to delete', 'error' => $e->getMessage()], 500);
        }
    }
    


}
