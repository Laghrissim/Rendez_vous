<?php

namespace App\Http\Controllers\Api;

use App\Events\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
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
    public function doctorApointment()
    {
    $user = auth()->user();

    // Retrieve the appointments of the authenticated user
    $appointments = $user->doctorAppointments;

    // Return the appointments as a response
    return response()->json($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        // Validate the request data
        
        // Create a new appointment
        $appointment = Appointment::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => auth()->user()->id, // Assign the authenticated user's ID to the appointment
            'doctor_id' => $request->doctor_id, // Assign the authenticated user's ID to the appointment
        ]);
        event(new Message('add Appointement','Message deleted successfully'));

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

public function edit(AppointmentRequest $request, string $id)
{
    
  
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
        $appointment = Appointment::findOrFail($id);

        // Delete the appointment
        $appointment->delete();
    
        // Broadcast an event to notify the frontend about the deleted appointment
    
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
    public function getDates()
    {
        // Retrieve all appointment dates from the database
        $dates = Appointment::pluck('date')->toArray();

        return $dates;
    }

    
    public function getClientsForDoctor($doctorId)
    {
        // Get all the appointments for the specific doctor
        $appointments = Appointment::where('doctor_id', $doctorId)->get();

        // Collect the user IDs of the clients who made an appointment to the doctor
        $clientIds = $appointments->pluck('user_id')->unique();

        // Get the client users based on the collected IDs
        $clients = User::whereIn('id', $clientIds)->get();

        return $clients;
    }

    public function confirm($id)
    {
        $item = Appointment::findOrFail($id);

        // Update the status to 'confirmed'
        $item->update(['status' => 'confirmed']);

        return response()->json(['message' => 'Appointment confirmed successfully']);
    }
    
    public function unconfirm($id)
    {
        $item = Appointment::findOrFail($id);

        // Update the status to 'unconfirmed'
        $item->update(['status' => 'unconfirmed']);

        return response()->json(['message' => 'Appointment unconfirmed successfully']);
    }
}
