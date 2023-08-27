<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Docteur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class DocteurController extends Controller


{
    
        public function getDoctors()
        {
            // Retrieve all users where type is 'doctor'
            $doctors = User::where('type', 'doctor')->get();
    
            return response()->json($doctors);
        }
        public function getDoctor($id)
        {
            try {
                $user = User::findOrFail($id); // Retrieve the user by ID or throw an exception if not found
                return response()->json(['name' => $user->name], 200);
                }
             catch (\Exception $e) {
                return response()->json(['error' => 'User not found'], 404); // Return an error response if the user is not found

            }
        }

        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
        public function docteurLogin(Request $request)
        {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
        
            if (Auth::guard('docteur')->attempt($request->only(['email', 'password']))) {
                // Authentication successful
                
                return response()->json(['message' => 'Login successful']);
            }
        
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }


        protected function createDoctor(Request $request)
    {
        $this->validator($request->all())->validate();
    
        $doctor = Docteur::create([
            'fullname' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    
        Auth::guard('docteur')->login($doctor); // Log in the 'docteur' user
    
        return response()->json(['message' => 'Docteur created successfully']);
    }

    public function docteurLogout(Request $request)
{
    Auth::guard('docteur')->logout();
    
    return response()->json(['message' => 'Logout successful']);
}

    
}
