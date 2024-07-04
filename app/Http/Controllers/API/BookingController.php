<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index(){
        $room = Booking::with('homestay')->latest()->get();
    
        $result = $room->map(function ($data){
            return [
                'id' => $data->id,
                'user_id' => $data->user_id,
                'homestays_id' => $data->homestays_id, 
                'homestay_name' => $data->homestay->name, 
                'rooms_id' => $data->rooms_id,
                'rooms_type' => $data->room->type,
                'day' => $data->day,
                'total_price' => $data->total_price,
                'status' => $data->staus,
                'status_room' => $data->status_room,
            ];
        });
    
        return response()->json(['message' => 'Data Berhasil di Akses', 'result' => $result], 200);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
            'rooms_id' => 'required|exists:rooms,id',
            'day' => 'required|integer|min:1',
            'status' => 'required|in:process,success,abort',
        ]);

        $room = Room::find($request->rooms_id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        if ($room->quota < 1) {
            return response()->json(['error' => 'Room quota is not enough'], 400);
        }

        $validateData['total_price'] = $room->price * $request->day;

        DB::beginTransaction();
        try {
            // Create booking
            $booking = Booking::create($validateData);

            // Reduce room quota
            $room->decrement('quota');

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => 'Booking successfully added', 'booking' => $booking], 201);
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            return response()->json(['error' => 'Booking failed to add: ' . $e->getMessage()], 500);
        }
    }

    


public function destroy(Booking $booking)
{
    if ($booking->delete()) {
        return redirect()->route('booking.index')->with('success', 'Data Successfully deleted');
    } else {
        return redirect()->back()->with('error', 'Data Failed to delete');
    }
}
    
        
}
