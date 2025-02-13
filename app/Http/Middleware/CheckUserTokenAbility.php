<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\Helpers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CheckUserTokenAbility
{

    private const GUARD_ADMIN = 'admin';
    private const GUARD_PUBLISHER = 'publisher';
    private const GUARD_CUSTOMER = 'customer';

    private const ERROR_UNAUTHORIZED_TOKEN = 'Unauthorized or invalid Token, please try again later.....';
    private const ERROR_UNAUTHORIZED_URL = 'Unauthorized or invalid URL access, please try again later.....';

    /**
     * Use Constants for Guard Names
     * @var array
     */
    private $guardUrlMapping = [
        '/api/v1/admin/' => self::GUARD_ADMIN,
        '/api/v1/publisher/' => self::GUARD_PUBLISHER,
        '/api/v1/customer/' => self::GUARD_CUSTOMER,
    ];

    private $helpers;

    public function __construct(Helpers $helpers)
    {
        $this->helpers = $helpers;
    }

    public function handle(Request $request, Closure $next)
    {
        foreach ($this->guardUrlMapping as $url => $guard) {
            if ($this->isRequestUrlMatches($request, $url)) {
                return $this->verifyTokenAbility($request, $guard, $next);
            }
        }
        return $next($request);
    }

    private function isRequestUrlMatches($request, $url): bool
    {
        return Str::startsWith($request->getRequestUri(), $url);
    }

    private function verifyTokenAbility($request, $guardName, $next)
    {
        if ($request->user('sanctum') == null) {
            Log::warning('Unauthorized access attempt: Invalid token');
            return $this->helpers->serverErrorResponse(
                self::ERROR_UNAUTHORIZED_TOKEN,
                '',
                '401'
            );
        }
        if (!$request->user('sanctum')->tokenCan($guardName)) {
            Log::warning('Unauthorized access attempt: Invalid URL access');
            return $this->helpers->serverErrorResponse(
                self::ERROR_UNAUTHORIZED_URL,
                '',
                '401'
            );
        }
        return $next($request);
    }
}
