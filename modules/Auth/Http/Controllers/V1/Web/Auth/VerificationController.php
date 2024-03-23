<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers\V1\Web\Auth;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\Web\V1\BaseController;

class VerificationController extends BaseController
{
    public function verify($userId, Request $request)
    {
        if ( ! $request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = user()->findOrFail($userId);

        if ( ! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
