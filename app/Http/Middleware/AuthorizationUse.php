<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationUse
{
    private const CONFIG_TOKEN_API = 'eyJhbGciOiJIUzUxMiJ9';

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('authorization');

        if ($token !== null) {
            preg_match('/Bearer\s(\S+)/', $token, $matches);
            if (!hash_equals($matches[1], self::CONFIG_TOKEN_API)) {
                return response()->json(['error' => 'Token invalid!'], 401);
            }
        } elseif ($request->getPathInfo() !== '/consumer/rabbit') {
            return response()->json(['error' => 'Token not informed!'], 401);
        }

        return $next($request);
    }
}
