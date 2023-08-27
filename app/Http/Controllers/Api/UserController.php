<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller


{
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
        public function Login(Request $request)
        {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
        
            if (Auth::attempt($request->only(['email', 'password']))) {
                // Authentication successful
                
                return response()->json(['message' => 'Login successful']);
            }
        
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }


        protected function create(Request $request)
    {
        $this->validator($request->all())->validate();
    
        $doctor = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    
        Auth::login($doctor); // Log in the 'docteur' user
    
        return response()->json(['message' => 'Docteur created successfully']);
    }

    public function Logout(Request $request)
{
    Auth::logout();
    
    return response()->json(['message' => 'Logout successful']);
}

    
}
