<?php
namespace App\Http\Controllers;

use App\Models\m_subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\MOrderController;

class MSubscriptionController extends Controller
{
    function showRemainingDay($user)
    {
        $subscription = DB::table('m_subscriptions')
            ->where('fk_company', $user->fk_company)
            ->orderByDesc('enddate')
            ->first();

        if ($subscription->enddate) {
            $enddate = $subscription->enddate;

            $enddate = Carbon::parse($enddate); // تاریخ پایان
            $today = Carbon::now(); // تاریخ امروز

            $diffInDays = $today->diffInDays($enddate, false); // false یعنی اختلاف منفی هم برگرده

            return $diffInDays;
        }
        return 0;

    }
    function createTrial($user)
    {
        $BPlan = new BPlanController();
        $startdate = Carbon::now();

        $enddate = $startdate->copy()->addDays(60);

        $plan = $BPlan->justShow(1);

        m_subscription::create([
            'fk_company' => $user->fk_company,
            'fk_product' => 1,
            'fk_plan' => 1,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'maxusers' => $plan->maxusers,
            'currentusers' => 1,
        ]);
    }
    function checkCompanySub($userCompanyId)
    {
        $code = 1;
        $message = null;

        $subscription = DB::table('m_subscriptions')
            ->where('fk_company', $userCompanyId)
            ->orderByDesc('enddate')
            ->first();
        if (!$subscription) {
            $message = __('messages.error.subscription_not_found');
            $code = 2;
        } else {
            $today = Carbon::today();
            if ($today->gt(Carbon::parse($subscription->enddate))) {
                $message = __('messages.error.subscription_expired');
                $code = 2;
            }
        }

        return [
            'message' => $message,
            'code' => $code,
        ];
    }
    function craete($fk_order)
    {
        $MOrder = new MOrderController();
        $User = new UserController();

        $order = $MOrder->justShow($fk_order);

        $user = $User->showWithColumn('id', $order->fk_user);

        $startdate = Carbon::now();

        switch ($order->period) {
            case 1:
                $enddate = $startdate->copy()->addMonth();
                break;

            case 2:
                $enddate = $startdate->copy()->addMonths(3);
                break;

            case 3:
                $enddate = $startdate->copy()->addYear();
                break;

            default:
                $enddate = $startdate->copy()->addMonth();
                break;
        }

        m_subscription::create([
            'fk_company' => $user->fk_company,
            'fk_product' => $order->fk_product,
            'fk_plan' => $order->fk_plan,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'maxusers' => $order->maxusers,
            'currentusers' => 1,
        ]);
    }
}
