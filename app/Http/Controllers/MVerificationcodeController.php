<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\m_verificationcode;

use App\Traits\ResponseTrait;

class MVerificationcodeController extends Controller
{
    use ResponseTrait;

    //manager verification
    function companyOtpRegister(Request $request, UserController $User)
    {
        $request->validate([
            'sendedto' => 'required|string|max:20'
        ]);
        $sendedto = $request->input('sendedto');

        $user = $User->showWithColumn('mobile', $sendedto);

        if (!$user)
            return $this->justCreate($sendedto);

    }
    function companyRegisterVerify(Request $request, UserController $User, AuthController $Auth)
    {
        $request->validate([
            'sendedto' => 'required|string|max:20',
            'name' => 'required|string'
        ]);
        $sendedto = $request->input('sendedto');
        $name = $request->input('name');
        $verificationcode = $request->input('verificationcode');

        $code = $this->justVerify($sendedto, $verificationcode);
        if (!$code)
            return $this->serverErrorResponse(__('messages.error.code_invalid'));
        $code->update(['is_used' => true]);

        $user = $User->showWithColumn('mobile', $sendedto);

        if (!$user)
            $user = $User->managerCreateWithMobile($sendedto, $name);

        return $Auth->optLogin($user);
    }

    function companyLogin(Request $request, UserController $User, AuthController $Auth)
    {
        $request->validate([
            'sendedto' => 'required|string|max:20',
            'verificationcode' => 'required',
        ]);
        $sendedto = $request->input('sendedto');
        $code = $request->input('code');

        $code = $this->justVerify($sendedto, $code);

        if (!$code)
            return $this->serverErrorResponse(__('messages.error.code_invalid'));

        $code->update(['is_used' => true]);

        $user = $User->showManagerWithMobile($sendedto);

        return $Auth->optLogin($user);
    }



    //user verfivation

    function userOtp(Request $request, UserController $User)
    {
        $request->validate([
            'sendedto' => 'required|string|max:20'
        ]);
        $sendedto = $request->input('sendedto');

        $user = $User->showWithColumn('mobile', $sendedto);

        if (!$user)
            return $this->serverErrorResponse(__('messages.error.not_found'));

        return $this->justCreate($sendedto);

    }



    public function userVerifyOtp(Request $request, AuthController $Auth, UserController $User)
    {

        $request->validate([
            'sendedto' => 'required|string',
            'verificationcode' => 'required|string'
        ]);
        $sendedto = $request->input('sendedto');
        $verificationcode = $request->input('verificationcode');

        $code = $this->justVerify($sendedto, $verificationcode);

        if (!$code)
            return $this->serverErrorResponse(__('messages.error.code_invalid'));

        $code->update(['is_used' => true]);

        $user = $User->showWithColumn('mobile', $sendedto);

        $res = $Auth->optLogin($user);

        return $res;
    }


    //public

    function justCreate($sendedto)
    {
        $verificationcode = $this->codeGenerator($sendedto);

        if ($verificationcode === false) {
            return response()->json([
                'message' => __('messages.error.verification_time')
            ], 400);
        }

        $message = "کد تایید همفضا: " . $verificationcode;

        $this->sendSms($message, $sendedto);

        $this->createRecord($sendedto, $verificationcode, 2);
    }
    function codeGenerator($sendedto)
    {
        $verificationcode = rand(1000, 9999);

        $lastEntry = DB::table('m_verificationcodes')
            ->where('sendedto', $sendedto)
            ->orderByDesc('created_at')
            ->first();

        if ($lastEntry && Carbon::parse($lastEntry->created_at)->diffInSeconds(now()) < 120) {
            return false;
        }

        return $verificationcode;
    }
    function createRecord($sendedto, $verificationcode, $addMinute)
    {
        m_verificationcode::create([
            'verificationcode' => $verificationcode,
            'sendedto' => $sendedto,
            'expires_at' => now()->addMinutes($addMinute),
        ]);
    }

    function justVerify($sendedto, $verificationcode)
    {
        $code = m_verificationcode::where('sendedto', $sendedto)
            ->where('verificationcode', $verificationcode)
            ->where('expires_at', '>=', now())
            ->where('is_used', false)
            ->orderBy('pk_verificationcode', 'DESC')
            ->first();

        return $code;
    }

}
