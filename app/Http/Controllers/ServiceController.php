<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json([
            "services" => $services,
        ], 200);
    }

    public function show($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response([
                "message" => "Service not found"
            ], 404);
        }
        return response([
            "service" => $service,
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "Name" => "required|string",
            "Description" => "string|nullable",
            "Price" => "required|numeric",
            'isAddOn' => 'boolean',
        ]);

        $service = Service::create($fields);

        return response([
            "service" => $service,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $fields = $request->validate([
            "Name" => "string",
            "Description" => "string|nullable",
            "Price" => "numeric",
            'isAddOn' => 'boolean',
        ]);

        $service->update($fields);

        return response([
            "service" => $service,
        ], 200);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response([
            "message" => "Service deleted",
        ], 200);
    }
}
