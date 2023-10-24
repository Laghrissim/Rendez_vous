<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;



class AdminController extends Controller
{
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
            // Authentication successful
            
            return response()->json(['message' => 'Login successful']);
        }
    
        throw ValidationException::withMessages([
            'email' => ['These credentials do not match our records.'],
        ]);
    }


    protected function createAdmin(Request $request)
{
    $this->validator($request->all())->validate();

    $admin = Admin::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
    ]);

    Auth::guard('admin')->login($admin); // Log in the 'docteur' user

    return response()->json(['message' => 'Admin created successfully']);
}

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        return response()->json(['message' => 'Logout successful']);
    }

    public function getCounts()
    {
        // Count users with type 'client'
        $clientCount = User::where('type', 'client')->count();

        // Count users with type 'doctor'
        $doctorCount = User::where('type', 'doctor')->count();

        // Count appointments with status 'confirmed'
        $confirmedAppointmentCount = Appointment::where('status', 'confirmed')->count();

        // Count appointments with status 'unconfirmed'
        $unconfirmedAppointmentCount = Appointment::where('status', 'unconfirmed')->count();

        return [
            'clientCount' => $clientCount,
            'doctorCount' => $doctorCount,
            'confirmedAppointmentCount' => $confirmedAppointmentCount,
            'unconfirmedAppointmentCount' => $unconfirmedAppointmentCount,
        ];
    }
    public function getClients()
    {
        // Get the client users based on the collected IDs
        $clients = User::where('type', 'client')->get();

        return $clients;
    }

    public function createDoctor(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Create a new user with the type "doctor"
        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->type = 'doctor'; // Set the user type to "doctor"
        $user->save();

        return response()->json(['message' => 'Doctor user created successfully']);
    }

    public function updateDoctor(Request $request, $id)
    {
        // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email,' . $id, // Exclude the current user's email
        'password' => 'nullable|string|min:6', // Password is optional for updates
        'password_confirmation' => 'nullable|same:password', // Password confirmation must match the password
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update user details
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];

    // Check if a new password is provided
    if ($request->filled('password')) {
        $user->password = bcrypt($validatedData['password']);
    }

    $user->save();

    return response()->json(['message' => 'Doctor user updated successfully']);
    }

    public function deleteDoctor($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'Doctor user deleted successfully']);
    }
}
