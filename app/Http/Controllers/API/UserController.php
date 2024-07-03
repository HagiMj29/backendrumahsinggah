<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->get();

        $result = $users->map(function ($data){
            
            return [
                'id'=>$data->id,
                'name'=>$data->name,
                'email'=>$data->email,
                'phone'=>$data->phone,
                'address'=>$data->address,
                'picture'=>$data->picture,
                'status'=>$data->status,
            ];

        });

        return response()->json(['message' => 'Data Berhasil di Akses', 'result'=>$result], 200);
    }



    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required|string|min:8',
            'phone'=> 'required',
        ]);
    
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'status'=>'user'
        ]);  
        
        $result = $user;
        
        return response()->json(['message' => 'Data Berhasil di Regist', 'result'=>$result], 201);
    
        
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();
    
            return response()->json(['user' => $user], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'phone' => 'required',
            'address' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'user',
        ]);

        if ($request->hasFile('picture')) {
            if ($user->picture && file_exists(public_path('images/' . $user->picture))) {
                unlink(public_path('images/' . $user->picture));
            }

            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validateData['picture'] = $filename;
        }

        if ($request->filled('password')) {
            $validateData['password'] = bcrypt($validateData['password']);
        } else {
            unset($validateData['password']);
        }

        $result =$validateData;

        try {
            $user->update($validateData);
            return response()->json(['message' => 'User updated successfully','result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update user', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json(['message' => 'User Delete successfully'], 200);
        } else {
            return response()->json(['message' => 'User Delete Error'], 500);
        }
    }
}
