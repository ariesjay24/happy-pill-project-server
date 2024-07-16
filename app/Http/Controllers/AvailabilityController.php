<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::all();
        return response()->json($availabilities, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'available' => 'required|boolean',
            ]);

            $date = Carbon::parse($request->date)->startOfDay()->timezone('UTC');

            $availability = Availability::updateOrCreate(
                ['date' => $date],
                ['available' => $request->available]
            );

            return response()->json($availability, 201);
        } catch (\Exception $e) {
            Log::error('Error marking date as unavailable:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to mark date as unavailable'], 500);
        }
    }

    public function destroy($date)
    {
        try {
            $parsedDate = Carbon::parse($date)->startOfDay()->timezone('UTC');

            $availability = Availability::where('date', $parsedDate)->firstOrFail();
            $availability->delete();

            return response()->json(['message' => 'Date marked as available again'], 200);
        } catch (\Exception $e) {
            Log::error('Error unmarking date as unavailable:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to mark date as available again'], 500);
        }
    }
}