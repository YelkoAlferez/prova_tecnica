<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;


class AuthController extends Controller
{
    public function apiLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'errors' => 'Unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json([
            'status' => 'User loged in',
            'token' => $token
        ]);
    }

    public function apiLogout()
    {
        $user = Auth::user();
        
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User loged out'
        ]);
    }

    public function apiCreate(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
                'remember' => 'nullable',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (Throwable) {
            return response()->json([
                'errors' => 'User not created'
            ]);
        }

        return response()->json([
            'status' => 'User created',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ]);
    }

    /**
     * Función para cerrar la sesión, devuelve al formulario de inicio de sesión
     */
    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
}
