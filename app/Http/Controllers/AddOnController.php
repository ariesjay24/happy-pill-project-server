<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    public function index()
    {
        $addOns = AddOn::all();
        return response()->json(['addOns' => $addOns], 200);
    }

    public function show($id)
    {
        $addOn = AddOn::find($id);
        if ($addOn) {
            return response()->json($addOn);
        } else {
            return response()->json(['message' => 'Add-On not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric'
        ]);

        $addOn = AddOn::create([
            'Name' => $request->Name,
            'Price' => $request->Price
        ]);

        return response()->json($addOn, 201);
    }

    public function update(Request $request, $id)
    {
        $addOn = AddOn::find($id);
        if (!$addOn) {
            return response()->json(['message' => 'Add-On not found'], 404);
        }

        $request->validate([
            'Name' => 'sometimes|required|string|max:255',
            'Price' => 'sometimes|required|numeric'
        ]);

        $addOn->update($request->all());
        return response()->json($addOn);
    }

    public function destroy($id)
    {
        $addOn = AddOn::find($id);
        if (!$addOn) {
            return response()->json(['message' => 'Add-On not found'], 404);
        }

        $addOn->delete();
        return response()->json(['message' => 'Add-On deleted']);
    }
}
?>
