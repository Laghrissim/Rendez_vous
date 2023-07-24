<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
    $user = auth()->user();

    // Retrieve the appointments of the authenticated user
    $appointments = $user->appointments;

    // Return the appointments as a response
    return response()->json($appointments);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        // Create a new appointment
        $appointment = Appointment::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => $validatedData['date'],
            'user_id' => auth()->user()->id, // Assign the authenticated user's ID to the appointment
        ]);

        // Return the created appointment as a response
        return response()->json($appointment, 201);
    }

    public function show(string $id)
    {
        // Retrieve the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Return the appointment as a response
        return response()->json($appointment);
    }

public function edit(Request $request, string $id)
{
    // Retrieve the appointment by ID
    

    // Validate the request data
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'date' => 'required|date',
    ]);
    $appointment = Appointment::findOrFail($id);
    // Update the appointment
    
    $appointment->title = $request->title ;
    $appointment->description = $request->description;
    $appointment->date = $request->date;
    $appointment->save();

    // Return the updated appointment as a response
    return response()->json($appointment, 201);
}


    public function destroy(string $id)
    {
        // Retrieve the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Delete the appointment
        $appointment->delete();

        // Return a success response
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
    public function getDates()
    {
        // Retrieve all appointment dates from the database
        $dates = Appointment::pluck('date')->toArray();

        return $dates;
    }
}
