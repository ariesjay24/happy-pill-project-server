<?php

namespace App\Http\Controllers;

use App\Models\AdminDashboard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $dashboard = AdminDashboard::all();
        return response([
            "dashboard" => $dashboard,
        ], 200);
    }

    public function show($id)
    {
        $dashboard = AdminDashboard::find($id);
        if (!$dashboard) {
            return response([
                "message" => "Admin Dashboard not found"
            ], 404);
        }
        return response([
            "dashboard" => $dashboard,
        ], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            "Content" => "required|string",
        ]);

        $dashboard = AdminDashboard::create($fields);

        return response([
            "dashboard" => $dashboard,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $dashboard = AdminDashboard::findOrFail($id);

        $fields = $request->validate([
            "Content" => "string",
        ]);

        $dashboard->update($fields);

        return response([
            "dashboard" => $dashboard,
        ], 200);
    }

    public function destroy($id)
    {
        $dashboard = AdminDashboard::findOrFail($id);
        $dashboard->delete();

        return response([
            "message" => "Admin Dashboard deleted",
        ], 200);
    }
}
