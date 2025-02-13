<?php

namespace Modules\Auth\Http\Controllers;

use App\Helper\Helpers;
use Illuminate\Http\Request;
use Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Modules\Customer\Models\Customer;
use Modules\Publisher\Models\Publisher;
use Modules\Auth\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    public function login(LoginRequest $request, string $type)
    {
        try {
            // Validate guard type
            if (!$this->isValidGuard($type)) {
                return Helpers::notFoundResponse('Invalid guard type.');
            }

            $email = $request->email;

            // user login
            $request->authenticate($type);

            // create token
            $token =  $this->createUserToken($type, $email);

            // return user info
            $user = $this->getUserInfo($type, $email);

            return response()->json([
                "message" => "Successfully Login!",
                "data"    => $user,
                "token"   =>  $token
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Login failed. Please check your credentials.', null, Response::HTTP_BAD_REQUEST);
        }
    } // End of login


    /**
     * get user info
     * @return object
     */
    private function getUserInfo(string $type, string $email)
    {
        switch ($type) {
            case 'admin':
                return Admin::firstWhere('email', $email);
            case 'publisher':
                return Publisher::firstWhere('email', $email);
            case 'customer':
                return Customer::firstWhere('email', $email);
            default:
                return null;
        }
    } // End Of getuserinfo


    /**
     * Create Token for user
     */
    private function createUserToken(string $type, string $email)
    {
        return $this->getUserInfo($type, $email)->createToken($type, [$type], now()->addWeek())->plainTextToken;
    } // end of createUserToken


    /**
     * Validate if the guard type is correct.
     */
    private function isValidGuard(string $type): bool
    {
        return in_array($type, ['admin', 'publisher', 'customer']);
    }

    /**
     * Destroy an authenticated tokens.
     */
    public function userLogout(Request $request): Response
    {
        $request->user()->tokens()->delete();
        return Helpers::successResponse('You have been successfully loggedOut.');
    } // End Of destroy

}//End of controller
