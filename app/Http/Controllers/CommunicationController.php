<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommunicationController extends Controller
{
    public function index()
    {
        $communications = Communication::all();
        return response([
            "communications" => $communications,
        ], 200);
    }

    public function show($id)
    {
        $communication = Communication::find($id);
        if (!$communication) {
            return response([
                "message" => "Communication not found"
            ], 404);
        }
        return response([
            "communication" => $communication,
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "UserID" => "required|exists:users,id",
            "Message" => "required|string",
        ]);

        $communication = Communication::create($fields);

        return response([
            "communication" => $communication,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $communication = Communication::findOrFail($id);

        $fields = $request->validate([
            "UserID" => "exists:users,id",
            "Message" => "string",
        ]);

        $communication->update($fields);

        return response([
            "communication" => $communication,
        ], 200);
    }

    public function destroy($id)
    {
        $communication = Communication::findOrFail($id);
        $communication->delete();

        return response([
            "message" => "Communication deleted",
        ], 200);
    }
}
