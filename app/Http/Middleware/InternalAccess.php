<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalAccess
{
    public function handle(Request $request, Closure $next)
    {
        $allowedIps = [
            '127.0.0.1',
        ];

        if (!in_array($request->ip(), $allowedIps)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }
        
        return $next($request);
    }
}
