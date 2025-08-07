<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        // $user = User::where('email', $credentials['email'])->first();

        // if (!$user || !Hash::check($credentials['password'], $user->password)) {
        //     return back()->withErrors(['email' => 'Invalid credentials']);
        // }

        // $token = $user->createToken('admin-token')->plainTextToken;

        // session(['admin_token' => $token]);

          $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt($credentials)) {
            $user = auth()->guard('admin')->user();
            $token = $user->createToken('admin-token')->plainTextToken;

            // $request->session()->regenerate();
             session(['admin_token' => $token]);

             return redirect()->route('admin.dashboard');
        }


        return redirect()->route('admin.dashboard');
    }
}
