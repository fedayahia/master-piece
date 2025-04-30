<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
    
        $users = User::when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($role, function ($query) use ($role) {
                return $query->where('role', $role);
            })
            ->get();
    
        return view('admin.users.index', compact('users'));
    }
    
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        Log::info('Starting user creation process', $request->all());
    
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
                'phone_number' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
                'role' => 'required|in:parent,instructor,admin',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            Log::info('Validation passed');
        } catch (ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ];
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $data['image'] = basename($path);
            Log::info('Image uploaded', ['image' => $data['image']]);
        } else {
            Log::info('No image uploaded');
        }
    
        try {
            $user = User::create($data);
            Log::info('User created successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Error creating user', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while creating the user.');
        }
    
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'phone_number' => 'sometimes|nullable|regex:/^\+?[0-9]{10,15}$/',
            'role' => 'sometimes|in:parent,instructor,admin',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = $request->only(['name', 'email', 'phone_number', 'role']);
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $data['image'] = basename($path);
        }
    
        $user->update($data);
    
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    



   

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User soft deleted successfully.');
}


public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);
    $user->restore();

    return redirect()->route('admin.users.index')->with('success', 'User restored successfully.');
}

    

}

