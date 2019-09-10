<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required|unique:user,email',
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return abort(401);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'message' => 'The given data was invalid.'
                    ]
            ], 422);
        };

        // return (new UserResource($request->user()))
        //     ->additional([
        //         'meta' => [
        //             'token' => $token
        //         ]
        //     ]);
    }

    public function logout()
    {
        auth()->logout();
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}
