<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'nullable',
        ]);


        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/')->withSuccess('Successful session');
        }

        return redirect('/')
        ->withErrors([
            'password' => 'El email o la contraseña son incorrectos.',
        ])
        ->withInput();

    }

    public function showLogin(){
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
}
