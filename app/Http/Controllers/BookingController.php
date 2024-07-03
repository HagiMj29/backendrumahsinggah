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
        
}
