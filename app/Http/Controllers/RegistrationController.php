<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class RegistrationController extends Controller
{
    /**
     * This function validates the form request from api and returns either
     * an array of errors or saves the user to the database and returns a json
     * response message.
     * @throws ValidationException
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        // Define error messages
        $messages = [
            'email.required' => 'Email is required',
            'name.required' => 'Full name is required',
            'username.unique' => 'Username is taken',
            'username.required' => 'Username is required',
            'phone_number.integer' => 'Phone number is invalid',
            'password.string' => 'Password format is invalid',
            'dob.before' => 'You should be at least 18 years old'
        ];

        // Define validation rules
        $dt = new Carbon();
        $before = $dt->subYears(18)->format('Y-m-d');

        $rules = [
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'dob'=>'required|before:' . $before,
            'phone_number' => 'required',
            'profile_image' => 'string',
            'password'=>'string|min:5'
        ];

        // Validate
        $validator = Validator::make($request->all(),$rules, $messages);

        // Return validation error
        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->errors()->toArray()], 201);
            return response()->json(['errors' => "Error registering"], 201);
        }

        // Continue with registration

        // TODO: Save image to file storage

        // TODO: Email verification

        $validated = $validator->validated();

        $now = Carbon::now();

        $insert = DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'dob' => $validated['dob'],
            'phone_number' => $validated['phone_number'],
            'profile_image' => $validated['profile_image'] ?? null,
            'password' => Hash::make($validated['password']),
            'created_at' => $now,
        ]);

        if ($insert){
            return response()->json(['message' => "User registered successfully"],201);
        }else{
            return response()->json(['message' => "There was an error registering user"],201);
        }

    }
}
