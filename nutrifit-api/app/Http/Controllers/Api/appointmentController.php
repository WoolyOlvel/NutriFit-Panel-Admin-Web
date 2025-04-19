<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class appointmentController extends Controller
{
    public function index()
    {
        // Fetch all appointments from the database
        $appointments = Appointment::all();

        $data = [
            'appointments' => $appointments,
            'status' => '200',
        ];

        // Return the appointments as a JSON response
        return response()->json(['appointments' => $appointments,'status'=> 200],200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'time' => 'required|datetime',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:255',
            'status_type' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => '400',
            ];

            return response()->json($validator->errors(), 400);
        }
        // Handle file upload

        $imagePath = null;
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')-> store('images/appointments', 'public');
        }

        // Create a new appointment
        $appointment = Appointment::create([
            'name' => $request->name,
            'type' => $request->type,
            'time' => $request->time,
            'image' => $imagePath,
            'status' => $request->status,
            'status_type' => $request->status_type,
        ]);
        return response()->json(['appointment' => $appointment,'status'=> 200],200);

    }

    public function show($id)
    {
        // Fetch a specific appointment by ID
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found', 'status' => 404], 404);
        }

        return response()->json(['appointment' => $appointment, 'status' => 200], 200);
    }

    public function update(Request $request, $id)
    {
        // Fetch the appointment by ID
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found', 'status' => 404], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'time' => 'required|datetime',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:255',
            'status_type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/appointments', 'public');
            $appointment->image = $imagePath;
        }

        // Update the appointment details
        $appointment->name = $request->name;
        $appointment->type = $request->type;
        $appointment->time = $request->time;
        $appointment->status = $request->status;
        $appointment->status_type = $request->status_type;

        // Save the updated appointment
        $appointment->save();

        return response()->json(['appointment' => $appointment, 'status' => 200], 200);
    }

    public function updatePartial(Request $request, $id){
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found', 'status' => 404], 404);
        }
        // Validate the incoming request data
        $appointment->fill($request->only([
            'name',
            'type',
            'time',
            'status',
            'status_type'
        ]));
        $appointment->save();
        return response()->json(['appointment' => $appointment, 'status' => 200], 200);
    }

    public function destroy($id)
    {
        // Fetch the appointment by ID
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found', 'status' => 404], 404);
        }

        // Delete the appointment
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully', 'status' => 200], 200);
    }

}
