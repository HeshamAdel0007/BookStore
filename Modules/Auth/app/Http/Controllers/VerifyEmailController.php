<?php

namespace Modules\Auth\Http\Controllers;

use App\Helper\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        // check user Verified or not
        if ($request->user()->hasVerifiedEmail()) {
            return Helpers::successResponse('Your email address is A Verified');
        }

        // check Verified user or not
        if ($request->user()->markEmailAsVerified()) {
            return Helpers::successResponse('Your email address is A Verified');
        }
    }
}
