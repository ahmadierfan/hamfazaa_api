<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language', 'en');
        
        if (!in_array($locale, ['en', 'fa'])) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
