<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Create a new user
    public function registerr(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'first_name' => 'required',
            'last_name' => 'required',
            'account_type' => 'required|in:student,instructor,admin',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'account_type' => $request->account_type,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
