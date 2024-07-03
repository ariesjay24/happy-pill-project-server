<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'Email' => 'required|string|unique:users,Email|email',
            'PhoneNumber' => 'required|string',
            'Password' => 'required|string',
            'Role' => 'required|string|in:Client,Photographer',
            'Address' => 'nullable|string',
        ]);

        $user = new User();
        $user->FirstName = $fields['FirstName'];
        $user->LastName = $fields['LastName'];
        $user->Email = $fields['Email'];
        $user->PhoneNumber = $fields['PhoneNumber'];
        $user->Password = Hash::make($fields['Password']);
        $user->Address = $fields['Address'];
        $user->Role = $fields['Role'];
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function registerAdmin(Request $request)
    {
        $adminExists = User::where('Role', 'Admin')->exists();
        if ($adminExists && (!Auth::check() || Auth::user()->Role !== 'Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $fields = $request->validate([
            "FirstName" => "required|string",
            "LastName" => "required|string",
            "Email" => "required|string|unique:users,Email|email",
            "PhoneNumber" => "required|string",
            "Password" => "required|string",
            "Role" => "required|string|in:Admin",
            "Address" => "nullable|string"
        ]);

        $user = new User();
        $user->FirstName = $fields["FirstName"];
        $user->LastName = $fields["LastName"];
        $user->Email = $fields["Email"];
        $user->PhoneNumber = $fields["PhoneNumber"];
        $user->Password = Hash::make($fields["Password"]);
        $user->Address = $fields["Address"];
        $user->Role = $fields["Role"];
        $user->save();

        return response([
            "user" => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Email' => 'required|string|email',
            'Password' => 'required|string',
        ]);

        $user = User::where('Email', $credentials['Email'])->first();

        if (!$user || !Hash::check($credentials['Password'], $user->Password)) {
            return response(['message' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged out'], 200);
    }
}
