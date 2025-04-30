<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'instructor')->get();


        return view('team', compact('users'));
    }
}
