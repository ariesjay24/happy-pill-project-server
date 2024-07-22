<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $fields = $request->validate([
                'FirstName' => 'required|string',
                'LastName' => 'required|string',
                'Email' => 'required|string|unique:users,Email|email',
                'PhoneNumber' => 'required|string',
                'Password' => 'required|string',
                'Role' => 'required|string|in:Client,Photographer',
                'Address' => 'nullable|string',
            ]);

            // Ensure the phone number is in the correct format
            $phoneNumber = $this->formatPhoneNumber($fields['PhoneNumber']);

            $user = new User();
            $user->FirstName = $fields['FirstName'];
            $user->LastName = $fields['LastName'];
            $user->Email = $fields['Email'];
            $user->PhoneNumber = $phoneNumber;
            $user->Password = Hash::make($fields['Password']);
            $user->Address = $fields['Address'];
            $user->Role = $fields['Role'];
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Registration failed: " . $e->getMessage());
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
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
            "Address" => "nullable|string"
        ]);

        // Ensure the phone number is in the correct format
        $phoneNumber = $this->formatPhoneNumber($fields['PhoneNumber']);

        $user = new User();
        $user->FirstName = $fields["FirstName"];
        $user->LastName = $fields["LastName"];
        $user->Email = $fields["Email"];
        $user->PhoneNumber = $phoneNumber;
        $user->Password = Hash::make($fields["Password"]);
        $user->Address = $fields["Address"];
        $user->Role = "Admin";
        $user->save();

        return response([
            "user" => $user,
        ], 201);
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Ensure it starts with the correct format for the Philippines (09XXXXXXXXX)
        if (substr($phoneNumber, 0, 2) == '63') {
            $phoneNumber = '0' . substr($phoneNumber, 2);
        } elseif (substr($phoneNumber, 0, 1) != '0') {
            $phoneNumber = '0' . $phoneNumber;
        }

        return $phoneNumber;
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

    public function currentUser(Request $request)
    {
        return response()->json(Auth::user());
    }
}
