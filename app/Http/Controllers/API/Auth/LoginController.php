<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::query()
            ->select('id', 'name', 'password', 'type', 'is_suspended')
            ->where('email', $request->validated('email'))
            ->first();

        if ($user) {
            if ($user->isSuspended()) {
                return response_error('You\'re currently suspended.', 403);
            }

            if (!Hash::check($request->validated('password'), $user->password)) {
                return response_error('Invalid credientials.', 403);
            }

            // Revoke all tokens...
            $user->tokens()->delete();

            return response_ok([
                'data' => [
                    'name' => $user->getName(),
                    'type' => $user->getUserType(),
                    '_token' => $user->createToken('sanctum')->plainTextToken,

                ]
            ]);
        } else {
            return response_unauthorized();
        }
    }
}
