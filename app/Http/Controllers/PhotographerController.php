<?php

namespace App\Http\Controllers;

use App\Models\Photographer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PhotographerController extends Controller
{
    public function index()
    {
        $photographers = Photographer::all();
        return response([
            "photographers" => $photographers,
        ], 200);
    }

    public function show($id)
    {
        $photographer = Photographer::find($id);
        if (!$photographer) {
            return response([
                "message" => "Photographer not found"
            ], 404);
        }
        return response([
            "photographer" => $photographer,
        ], 200);
    }

    public function store(Request $request)
{
    try {
        $fields = $request->validate([
            "UserName" => "required|string",
            "ServiceType" => "required|string",
            "PhotographerName" => "required|string",
            "BookingDate" => "required|date",
            "BookingTime" => "nullable|date_format:H:i",
            "Location" => "required|string",
        ]);

        // Log the validated fields for debugging
        \Log::info('Validated fields:', $fields);

        // Fetch related IDs from their names
        $user = User::where('Name', $fields['UserName'])->firstOrFail();
        $service = Service::where('Name', $fields['ServiceType'])->firstOrFail();
        $photographer = Photographer::where('Name', $fields['PhotographerName'])->firstOrFail();

        // Create booking
        $booking = Booking::create([
            'UserID' => $user->UserID,
            'ServiceID' => $service->ServiceID,
            'PhotographerID' => $photographer->PhotographerID,
            'BookingDate' => $fields['BookingDate'],
            'BookingTime' => $fields['BookingTime'],
            'Location' => $fields['Location'],
            'Status' => 'Confirmed',
        ]);

        return response([
            "booking" => $booking,
        ], 201);
    } catch (\Exception $e) {
        // Log the error message and the request data for debugging
        \Log::error('Error creating booking: ' . $e->getMessage());
        \Log::error('Request data: ' . json_encode($request->all()));

        return response([
            "message" => "Error creating booking",
            "error" => $e->getMessage()
        ], 500);
    }
}


    public function update(Request $request, $id)
    {
        $photographer = Photographer::findOrFail($id);

        $fields = $request->validate([
            "UserID" => "exists:users,id",
            "Bio" => "string|nullable",
            "Specialization" => "string"
        ]);

        $photographer->update($fields);

        return response([
            "photographer" => $photographer,
        ], 200);
    }

    public function destroy($id)
    {
        $photographer = Photographer::findOrFail($id);
        $photographer->delete();

        return response([
            "message" => "Photographer deleted",
        ], 200);
    }
}
