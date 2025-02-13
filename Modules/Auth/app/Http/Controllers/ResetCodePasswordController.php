<?php

namespace Modules\Auth\Http\Controllers;

use App\Helper\Helpers;
use Illuminate\Http\Request;
use Modules\Admin\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Auth\Models\ResetCodePassword;
use Modules\Auth\Emails\SendCodeResetPassword;

class ResetCodePasswordController extends Controller
{
    public function forgotPassword(Request $request, $type): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|exists:' . $type . 's',
        ]);

        // Delete all old code that the user sent before.
        ResetCodePassword::where('email', $request->email)->delete();

        // Generate random code
        $data['code'] = mt_rand(1000000, 9999999);

        // Create a new code
        $codeData = ResetCodePassword::create($data);

        // Send email to user
        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));
        return Helpers::successResponse('We send password reset code, please check your email.');
    } // End Of forgotpassword


    public function resetPassword(Request $request, $type)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        //Check if it has not expired: the time is one hour
        $codeCheck = $this->codeCheck($passwordReset);

        // Check guard
        if (Auth::guard($type)) {
            // find user's email
            $user = $this->findUser($type, $passwordReset);
            if ($user  != null) {
                // update user password
                $this->updateUser($user, $type, $request);
                // delete current code
                $passwordReset->delete();
                return Helpers::successResponse('Password has been successfully reset');
            } else {
                return Helpers::notFoundResponse('We can\'t find a user with that e-mail address.');
            }
        }
    } // End Of resetPassword

    private function findUser($type, $passwordReset)
    {
        switch ($type) {
            case 'admin':
                return Admin::firstWhere('email', $passwordReset->email);
            case 'publisher':
                return Publisher::firstWhere('email', $passwordReset->email);
            case 'customer':
                return Customer::firstWhere('email', $passwordReset->email);
            default:
                return null;
        }
    } // End Of finduser

    private function codeCheck($passwordReset)
    {
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return Helpers::successResponse('Passwords code is expire');
        }
    } // end of codeCheck


    private function updateUser($user, $type, $request): void
    {
        $id = $user->id;
        $tableName = $type . 's';
        $password = bcrypt($request->password);
        DB::table($tableName)
            ->where('id', $id)
            ->update(['password' => $password]);
    } // end of updateUser

} // end of controller
