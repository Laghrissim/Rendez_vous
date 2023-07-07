<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Docteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DocteurController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:docteurs',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $docteur = Docteur::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::guard('docteur')->login($docteur);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => $docteur,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('docteur')->attempt($credentials)) {
            $docteur = Auth::guard('docteur')->user();

            return response()->json([
                'success' => true,
                'message' => 'Authentication successful',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials',
        ]);
    }
}
