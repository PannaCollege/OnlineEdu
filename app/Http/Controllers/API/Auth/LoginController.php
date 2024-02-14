<?php

namespace App\Http\Controllers\API\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Online edu default login
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Online edu login using google
     */
    public function handleGoogleCallback()
    {
        try {
            $user = DB::transaction(function () {
                Socialite::driver('google')->stateless()->user();

                $googleUser = Socialite::driver('google')->user();

                $user = User::where('google_id', $googleUser->id)->first();

                if (!$user) {
                    $user = User::registerByGoogle($googleUser);
                }

                return $user;
            });

            return response_ok([
                'data' => [
                    'name' => $user->getName(),
                    'type' => $user->getUserType(),
                    '_token' => $user->createToken('sanctum')->plainTextToken,

                ]
            ]);
        } catch (Exception $exception) {
            return response_error($exception->getMessage(), $exception->getCode());
        }
    }
}
