<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->get();

        $result = $users->map(function ($data){
            
            return [
                'id'=>$data->id,
                'name'=>$data->name,
                'email'=>$data->email,
                'phone'=>$data->phone,
                'address'=>$data->address,
                'picture'=>$data->picture,
            ];

        });

    }

    public function create(){
        
    }

    public function store(){
        
    }

    public function edit(){
        
    }

    public function update(){
        
    }

    public function destroy(){
        
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
            'phone' => $request->input('alamat'),
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(200);
    }
}
