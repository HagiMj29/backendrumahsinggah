<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Favorite;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                'homestay_picture' => $data->homestay->picture,
                'homestay_address' => $data->homestay->address,
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


    public function checkFavorite($homestay_id)
{
    $user_id = request('user_id');
    $favorite = Favorite::where('user_id', $user_id)
        ->where('homestays_id', $homestay_id)
        ->first();

    if ($favorite) {
        return response()->json(['data' => $favorite]);
    } else {
        return response()->json(['data' => null]);
    }
}



    // public function destroy(Favorite $favorite)
    // {
    //     try {
    //         $favorite->delete();
    //         return response()->json(['message' => 'Data successfully deleted'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Data failed to delete', 'error' => $e->getMessage()], 500);
    //     }
    // }

    public function destroy($homestayId, Request $request)
{
    try {
        $userId = $request->query('user_id');
        $favorite = Favorite::where('homestays_id', $homestayId)->where('user_id', $userId)->firstOrFail();
        $favorite->delete();
        return response()->json(['message' => 'Data successfully deleted'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Data failed to delete', 'error' => $e->getMessage()], 500);
    }
}



}
