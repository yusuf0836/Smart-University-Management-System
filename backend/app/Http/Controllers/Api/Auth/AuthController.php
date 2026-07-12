<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Login
     *
     * Authenticate a user and return a Sanctum access token.
     *
     * @group Authentication
     *
     * @unauthenticated
     *
     * @bodyParam email string required User email address. Example: admin@example.com
     * @bodyParam password string required User password. Example: password123
     *
     * @response 200 {
     *   "success": true,
     *   "token": "1|abcdefghijklmnopqrstuvwxyz",
     *   "user": {
     *     "id": 1,
     *     "name": "Admin",
     *     "email": "admin@example.com"
     *   }
     * }
     *
     * @response 401 {
     *   "success": false,
     *   "message": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Get Authenticated User
     *
     * Returns the currently authenticated user's information.
     *
     * @group Authentication
     *
     * @authenticated
     *
     * @response 200 {
     *   "id": 1,
     *   "name": "Admin",
     *   "email": "admin@example.com"
     * }
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout
     *
     * Revoke the current Sanctum access token and log out the authenticated user.
     *
     * @group Authentication
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Logged out successfully"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}