<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;



class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);  
        return view('admin.user_view', compact('users')); 
    }

    public function create()
    {
        return view('admin.user_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
        ]);

        return redirect()->route('admin.user_view')->with('success', 'User added successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);  
        return view('admin.user_edit', compact('user')); 
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);  

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,  
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.user_view')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);  
        
        if ($user) {
            $user->delete();  
            return redirect()->route('admin.user_view')->with('success', 'User deleted successfully.');
        }

        return redirect()->route('admin.user_view')->with('error', 'User not found.');
    }
}
