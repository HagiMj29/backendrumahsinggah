<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request){

        $query = Booking::query();
    
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->whereHas('homestay', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
            $q->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });

        });
    }

    $booking = $query->latest()->get();
    $title = "Booking";
    
    return view('booking.index', ['booking' => $booking, 'listtitle' => $title, 'search' => $request->input('search')]);

    }



    public function create(){
        $users = User::all();
        $homestays = Homestay::all();
        $room = Room::all();
        return view('booking.create',['users'=>$users,'homestays'=>$homestays,'room'=>$room]);
    }


    public function store(Request $request){
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'homestays_id' => 'required|exists:homestays,id',
            'rooms_id' => 'required|exists:rooms,id',
            'day' => 'required|integer|min:1',
            'status' => 'process',
        ]);

        $room = Room::find($request->rooms_id);

         if (!$room) {
            return redirect()->back()->with('error', 'Room not found');
        }

        if ($room->quota < 1) {
            return redirect()->back()->with('error', 'Room quota is not enough');
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
    
            return redirect()->route('booking.index')->with('success', 'Booking Successfully added');
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
    
            return redirect()->back()->with('error', 'Booking Failed to add: ' . $e->getMessage());
        }

    }

    public function edit(Booking $booking){
        $users = User::all();
        $homestays = Homestay::all();
        $room = Room::all();
        return view('booking.edit',['booking'=>$booking,'users'=>$users,'homestays'=>$homestays,'room'=>$room]);
    }

    public function update(Request $request, Booking $booking)
{
    $validateData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'homestays_id' => 'required|exists:homestays,id',
        'rooms_id' => 'required|exists:rooms,id',
        'day' => 'required|integer|min:1',
        'status' => 'required|in:process,success,abort',
    ]);

    $newRoom = Room::find($request->rooms_id);

    if (!$newRoom) {
        return redirect()->back()->with('error', 'Room not found');
    }

    // Calculate total price
    $validateData['total_price'] = $newRoom->price * $request->day;

    DB::beginTransaction();
    try {
        // Restore the quota of the old room if the room has changed
        if ($booking->rooms_id != $request->rooms_id) {
            $oldRoom = Room::find($booking->rooms_id);
            if ($oldRoom) {
                $oldRoom->increment('quota');
            }

            // Check if the new room has enough quota
            if ($newRoom->quota < 1) {
                throw new \Exception('New room quota is not enough');
            }
        }

        // Update booking
        $booking->update($validateData);

        DB::commit();

        return redirect()->route('booking.index')->with('success', 'Booking successfully updated');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with('error', 'Booking failed to update: ' . $e->getMessage());
    }

   
}

public function checkout_page(Booking $booking){
    $users = User::all();
    $homestays = Homestay::all();
    $rooms = Room::all(); // Ganti nama variabel untuk konsistensi
    return view('booking.checkout', [
        'booking' => $booking,
        'users' => $users,
        'homestays' => $homestays,
        'rooms' => $rooms // Ganti nama variabel untuk konsistensi
    ]);
}


public function checkout(Request $request, Booking $booking) // Ganti nama parameter untuk konsistensi
{
    $validateData = $request->validate([
        'status_room' => 'required',
    ]);

    DB::beginTransaction();

    try {
        $room = Room::findOrFail($booking->rooms_id); // Gunakan findOrFail untuk menangani jika room tidak ditemukan
        $room->increment('quota');

        $booking->update($validateData);

        DB::commit();

        return redirect()->route('booking.index')->with('success', 'Checkout successfully processed');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Checkout failed: ' . $e->getMessage());
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
