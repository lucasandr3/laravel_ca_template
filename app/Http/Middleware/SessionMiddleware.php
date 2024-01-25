<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "<pre>"; var_dump("aquii no session"); echo "</pre>"; die;
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            session_start();
            $request->merge(['session' => $_SESSION]);
        }

        return $next($request);
    }
}
