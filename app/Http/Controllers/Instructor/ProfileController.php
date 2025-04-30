<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('instructor.profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function edit()
    {
        return view('instructor.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-\(\)]{7,20}$/'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000'
            ],
            'current_password' => [
                'nullable',
                'required_with:new_password',
                'current_password'
            ],
            'new_password' => [
                'nullable',
                'confirmed',
                Rules\Password::defaults(),
                'different:current_password'
            ],
        ], [
            'phone_number.regex' => 'Please enter a valid phone number format',
            'image.dimensions' => 'Image dimensions should be maximum 2000x2000px',
            'new_password.different' => 'New password must be different from current password'
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image) {
                    Storage::delete($user->image);
                }
                
                $validated['image'] = $request->file('image')->store('profile-images');
            }

            // Update password if provided
            if (!empty($validated['new_password'])) {
                $validated['password'] = Hash::make($validated['new_password']);
                unset($validated['new_password']);
                unset($validated['current_password']);
            }

            $user->update($validated);

            return redirect()->route('user.edit')
                ->with('success', 'Profile updated successfully!')
                ->with('alert-type', 'success');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update profile: ' . $e->getMessage())
                ->with('alert-type', 'error')
                ->withInput();
        }
    }
}