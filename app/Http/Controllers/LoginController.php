<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        // If user signs with email
        if ($request->has("email")){
            $rules = [
                'email' => 'required|email',
                'password' => 'required|string|min:5'
            ];

            $messages = [
                'email.required' => 'Email is required',
                'email.email' => 'Email format is invalid',
                'password.required' => 'Password is required',
                'password.string' => 'Password format is invalid'
            ];

            // Validate request format
            $validator = Validator::make($request->all(),$rules,$messages);

            // Return error response if validation fails
            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->toArray()], 201);
            }

            $validated = $validator->validated();

            $email = $validated['email'];
            $password =  $validated['password'];

            $user = User::where('email', $email)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return response()->json(['error' => 'The provided credentials are incorrect.'], 201);

            }

            $token = $user->createToken('auth_token',['profile:all']);

            return response()->json(['token' => $token->plainTextToken], 201);

        }
        else if ($request->has("username")){
            $rules = [
                'username' => 'required|string',
                'password' => 'required|string|min:5'
            ];

            $messages = [
                'username.required' => 'Username is required',
                'password.required' => 'Password is required',
                'password.string' => 'Password format is invalid'
            ];

            // Validate request format
            $validator = Validator::make($request->all(),$rules,$messages);

            // Return error response if validation fails
            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->toArray()], 201);
            }

            $validated = $validator->validated();

            $username = $validated['username'];
            $password =  $validated['password'];

            $user = User::where('username', $username)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return response()->json(['error' => 'The provided credentials are incorrect.'], 201);

            }

            $token = $user->createToken('auth_token',['profile:all']);

            return response()->json(['token' => $token->plainTextToken], 201);
        }
        else{
            return response()->json(['error' => "Invalid request"], 201);
        }
    }


    public function logout(Request $request)
    {

    }
}
