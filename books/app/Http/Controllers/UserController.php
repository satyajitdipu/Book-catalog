<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Laravel\Sanctum\PersonalAccessToken;


class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        return response(['user' => $user]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($data)) {
            $user = auth()->user();

            // Create a personal access token for the user
            $token = $user->createToken('Token Name');

            // Get the plain text token
            $plainTextToken = $token->plainTextToken;

            if (!$plainTextToken) {
                return response()->json([
                    'message' => 'Unable to generate access token'
                ], 500);
            }

            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $plainTextToken
            ], 201);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
    
        Auth::logout();
        PersonalAccessToken::truncate();
    
        return response("Logout successfully");
    }
    public function me(Request $request)
{
    return $request->user();
}

}
