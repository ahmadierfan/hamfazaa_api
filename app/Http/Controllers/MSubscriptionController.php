<?php
namespace App\Http\Controllers;

use App\Models\m_subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\MOrderController;

class MSubscriptionController extends Controller
{
    function checkCompanySub($userCompanyId)
    {
        $subscription = DB::table('m_subscriptions')
            ->where('fk_company', $userCompanyId)
            ->orderByDesc('end_date')
            ->first();
        if (!$subscription) {
            $message = _('messages.error.subscription_not_found');
            $code = 2;
        }
        $today = Carbon::today();
        if ($today->gt(Carbon::parse($subscription->end_date))) {
            $message = __('messages.error.subscription_expired');
            $code = 2;
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
            case 1: // ماهانه
                $enddate = $startdate->copy()->addMonth();
                break;

            case 2: // سه ماهه
                $enddate = $startdate->copy()->addMonths(3);
                break;

            case 3: // سالانه
                $enddate = $startdate->copy()->addYear();
                break;

            default:
                // مقدار پیش‌فرض مثلاً یک ماه
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
