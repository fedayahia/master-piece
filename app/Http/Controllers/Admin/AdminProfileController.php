<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }
    public function update(Request $request)
    {
        $admin = auth()->user();
    
        // Validate the inputs
        $request->validate([
'full_name' => [
    'required',
    'string',
    'min:2',
    'max:255',
    'regex:/^[\p{L}]+$/u'
],
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone_number' => 'nullable|string|regex:/^[0-9]{10,15}$/', // phone number validation
            'password' => 'nullable|confirmed|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Ensure full name is properly split and handled
        $fullName = explode(' ', $request->input('full_name'));
    
    
    
        $admin->email = $request->input('email');
        $admin->phone_number = $request->input('phone_number');
    
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }
    
        // Handle image upload
        if ($request->hasFile('image')) {
            if ($admin->image) {
                Storage::delete('public/profile_images/' . $admin->image);
            }
            $path = $request->file('image')->store('profile_images', 'public');
            $admin->image = basename($path);
        }
        
        $admin->save();
    
        // Return success message
        return redirect()->route('admin.user.profile')->with('success', 'Profile updated successfully.');
    }
    public function show()
    {
        return view('admin.profile.show'); // Make sure this matches your view's path
    }

}
