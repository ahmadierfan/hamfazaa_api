<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChecUserPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!isset(auth()->user()->id))
            return response()->json(['message' => __('messages.unauthorized')], 401);

        //subscription check
        $userCompanyId = auth()->user()->fk_company;
        if (!$userCompanyId)
            return response()->json(['message' => __('messages.error.company_not_found')], 403);
        $subscription = DB::table('m_subscriptions')
            ->where('fk_company', $userCompanyId)
            ->orderByDesc('end_date')
            ->first();
        if (!$subscription)
            return response()->json(['message' => __('messages.error.subscription_not_found')], 403);
        $today = Carbon::today();
        if ($today->gt(Carbon::parse($subscription->end_date)))
            return response()->json(['message' => __('messages.error.subscription_expired')], 403);

        return $next($request);
    }
}
