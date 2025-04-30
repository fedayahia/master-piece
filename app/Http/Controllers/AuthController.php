<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:15',
                'regex:/^\+?[0-9]{10,15}$/'
            ]
        ], [
            // Validation messages...
        ]);
        
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'phone_number' => $request->phone_number,
        ]);
    
 
    
        // Redirect with a success message
        return redirect()->route('login.form')->with('success', 'Account created successfully. You can now log in.');
    }


    public function showLoginForm()
{
    return view('auth.login');  
}


public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'instructor':
                return redirect()->route('instructor.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    return back()->withErrors([
        'auth' => 'Incorrect email or password',
    ])->withInput();
}
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
