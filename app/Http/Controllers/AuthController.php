<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\TokenEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{
    /**
     * Create tokens
     * access_token expire in 1 day.
     * refresh_token expire in 7 days.
     * 
     * @param User $user
     * @return void
     */
    public function createTokens(User $user)
    {
        $access_token = $user->createToken(TokenEnum::ACCESS_TOKEN->value,
                                        [TokenEnum::ISSUE_VERIFY_TOKEN],
                                        Carbon::now()->addDays(config('sanctum.access_token_expiration')))->plainTextToken;
        $refresh_token = $user->createToken(TokenEnum::REFRESH_TOKEN->value,
                                        [TokenEnum::ISSUE_ACCESS_TOKEN],
                                        Carbon::now()->addDays(config('sanctum.refresh_token_expiration')))->plainTextToken;
        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
        ];
    }

    /**
     * Refresh tokens
     *
     * @param Request $request
     * @return void
     */
    public function refreshTokens(Request $request)
    {
        $request->user()->tokens()->delete();
        $tokens = self::createTokens($request->user());

        return response()->json($tokens);
    }

    /**
     * Verify access_toke
     *
     * @param Request $request
     * @return void
     */
    public function verifyToken(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions()->pluck('name');
        foreach ($permissions as $key => $permission) {
            $permissions_arr = explode('.', $permission);
            $arr[$permissions_arr[0]][] = $permissions_arr[1];
        }

        return json_encode($arr);
    }

    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        $tokens = self::createTokens($user);

        return response()->json($tokens);
    }
}
