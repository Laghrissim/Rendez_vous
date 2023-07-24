<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    
    
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:6',
        ]);

        $client = Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        Auth::guard('client')->login($client);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => $client,
        ],201)->header('Content-Type', 'application/json');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($credentials)) {
            $client = Auth::guard('client')->user();
            

            return response()->json([
                'success' => true,
                'message' => 'Authentication successful',
                'data' => $client
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials',
        ]);
    }

}
