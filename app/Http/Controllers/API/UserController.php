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

        // if (Auth::attempt($credentials)) {
        //     // Authentication passed...
        //     $user = Auth::user();

        //     return response()->json(['user' => $user], 200);
        // }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'password' => $request->password,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'address' => $user->address ?? '',
                    'picture' => $user->picture ?? '',
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
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
            'status' => 'required',
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
            // $validateData['password'] = bcrypt($validateData['password']);
            $validateData['password'] = Hash::make($validateData['password']);
        } else {
            unset($validateData['password']);
        }

        // $result =$validateData;

        // try {
        //     $user->update($validateData);
        //     return response()->json(['message' => 'User updated successfully','result' => $result], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Failed to update user', 'error' => $e->getMessage()], 500);
        // }
        try {
            $user->update($validateData);
            return response()->json(['message' => 'User updated successfully'], 200);
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

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'message' => 'Email exists in the system.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'picture' => $user->picture,
                    'status' => $user->status,
                ]
            ], 200);
        } else {
            return response()->json(['message' => 'Email not found.'], 404);
        }
    }


    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validateData = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $validateData['password'] = bcrypt($validateData['password']);

        try {
            $user->update(['password' => $validateData['password']]);
            return response()->json(['message' => 'Password updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update password', 'error' => $e->getMessage()], 500);
        }
    }

}
