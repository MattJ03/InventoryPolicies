<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|unique:users|max:255',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
     Auth::create($validatedData) ;
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }
        else {
            abort(401);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }



}
