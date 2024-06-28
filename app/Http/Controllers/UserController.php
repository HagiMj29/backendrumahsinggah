<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
    
        $users = $query->latest()->get();
        $title = "Users";
    
        return view('users.index', ['users' => $users, 'listtitle' => $title, 'search' => $request->input('search')]);
    }

    public function create(){

        return view('users.create');
        
    }

    public function store(Request $request)
    {
    $validateData = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8', 
        'phone' => 'required',
        'address' => 'required',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'required',
    ]);

    // Handle file upload
    if ($request->hasFile('picture')) {
        $file = $request->file('picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $validateData['picture'] = $filename;
    }

    // Hash the password before storing
    $validateData['password'] = bcrypt($validateData['password']);

    if (User::create($validateData)) {
        return redirect()->route('users.index')->with('success', 'Data Berhasil di Tambahkan');
    } else {
        return redirect()->back()->with('error', 'Gagal Menyimpan Data');
    }
    }

    
    public function edit(User $user){
        
        return view('users.edit',['user'=>$user]);

    }

    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8', 
            'phone' => 'required',
            'address' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        // Handle file upload
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validateData['picture'] = $filename;
        }

        // Hash the password if it's being updated
        if ($request->filled('password')) {
            $validateData['password'] = bcrypt($validateData['password']);
        } else {
            unset($validateData['password']);
        }

        if ($user->update($validateData)) {
            return redirect()->route('users.index')->with('success', 'Data Berhasil di Update');
        } else {
            return redirect()->back()->with('error', 'Gagal Mengupdate Data');
        }
    }

    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('users.index')->with('success', 'Data Berhasil di Hapus');
        } else {
            return redirect()->back()->with('error', 'Gagal Menghapus Data');
        }
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
