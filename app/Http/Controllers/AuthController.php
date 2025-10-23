<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\SUserloginController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

use App\Traits\ResponseTrait;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use ResponseTrait;

    function optLogin($user)
    {
        return $this->tokenGenerator($user);

    }
    function tokenGenerator($user)
    {
        $MSubscription = new MSubscriptionController();

        $token = JWTAuth::fromUser($user);

        $remainingDays = $MSubscription->showRemainingDay($user);

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'remainingDays' => $remainingDays,
            'message' => __('auth.login_success'),
            'user' => $user
        ]);
    }
    function webLogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'password' => 'required|string|max:255',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            // Create new user with random password
            $user = User::create([
                'mobile' => $request->email,
                'password' => Hash::make(bin2hex(random_bytes(16))),
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => JWTAuth::fromUser($user)
        ]);
    }
    public function login(Request $request, SUserloginController $SUserlogin)
    {
        $request->validate([
            'mobile' => 'required',
            'password' => 'required|min:6',
        ]);

        $pk_userlogin = $SUserlogin->create($request, 'mobile');

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            $SUserlogin->update($pk_userlogin, null, "UserNotExist");
            return response()->json(['error' => __('auth.unauthorized')], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            $SUserlogin->update($pk_userlogin, null, "IncorrectPassword");
            return response()->json(['error' => __('auth.password')], 401);
        }

        $token = JWTAuth::fromUser($user);

        $SUserlogin->update($pk_userlogin, null, null, $user->id);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
        ];

        return response()->json([
            'user' => $userData,
            'token' => $token,
            'message' => __('auth.login_success')
        ]);
    }
    public function loginJustToken(Request $request, SUserloginController $SUserlogin)
    {
        $request->validate([
            'nationalcode' => 'required|min:10',
            'password' => 'required|min:6',
        ]);

        $pk_userlogin = $SUserlogin->create($request, 'nationalcode');

        $user = User::where('nationalcode', $request->nationalcode)->first();

        if (!$user) {
            $SUserlogin->update($pk_userlogin, null, "UserNotExist");
            return response()->json(['error' => __('auth.unauthorized')], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            $SUserlogin->update($pk_userlogin, null, "IncorrectPassword");
            return response()->json(['error' => __('auth.failed')], 401);
        }

        $token = JWTAuth::fromUser($user);

        $SUserlogin->update($pk_userlogin, null, null, $user->id);

        return $token;
    }
    public function companyLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'message' => __('auth.success')
        ]);
    }
    public function syncUser(Request $request)
    {
        $user = null;

        if (isset($request->email)) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $user = User::where('email', $request->email)->first();

            $arr = [
                'id' => $request->id,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ];
            User::create($arr);
        } elseif (isset($request->mobile)) {
            $request->validate([
                'mobile' => 'required',
            ]);

            $arr = [
                'id' => $request->id,
                'mobile' => $request->mobile,
            ];

            $user = User::where('mobile', $request->mobile)->first();
            User::create($arr);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.error.validation'),
                'code' => 400,
                'issues' => "email or mobile not send",
            ], 400);
        }
    }
    public function profile()
    {
        $user = JWTAuth::user();

        return response()->json(['user' => $user]);
    }
}
