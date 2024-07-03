<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service; // Add this import
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'service')->get();
        foreach ($bookings as $booking) {
            $booking->AddOns = json_decode($booking->AddOns, true) ?? [];
            $totalPrice = $booking->service->Price;

            foreach ($booking->AddOns as $addOnName) {
                $addOn = Service::where('Name', $addOnName)->first();
                if ($addOn) {
                    $totalPrice += $addOn->Price;
                }
            }

            $booking->TotalPrice = $totalPrice;
        }

        return response()->json($bookings);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json(['message' => 'Booking updated successfully']);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
