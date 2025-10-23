<?php
namespace App\Http\Controllers;

use App\Models\m_order;

use Illuminate\Http\Request;

class MOrderController extends Controller
{
    function create(ZarinpalController $Zarinpal, Request $request, BPlanController $BPlan, MGatewaytransactionController $MGatewaytransaction)
    {
        $pk_plan = $request->planID;
        $period = $request->periodType;

        $plan = $BPlan->justShow($pk_plan);

        $periodNumber = 1;
        switch ($period) {
            case 'monthly':
                $periodNumber = 0;
                $coefficient = 1;
                break;
            case 'quarterly':
                $periodNumber = 1;
                $coefficient = 3;
                break;
            case 'annually':
                $periodNumber = 2;
                $coefficient = 12;
                break;
            default:
                $periodNumber = 1;
                break;
        }

        $totalprice = json_decode($plan->price)[$periodNumber] * $coefficient;

        $order = $this->justCreate(auth()->user()->id, 1, $pk_plan, $plan->maxusers, $totalprice, $periodNumber + 1);

        $payData = $Zarinpal->pay($totalprice, $order->pk_order);

        $MGatewaytransaction->justCreate($order->pk_order, $totalprice, $payData['authority']);

        return [
            'payment_url' => $payData['link']
        ];

    }
    function justShow($pk_order)
    {
        $data = m_order::where('pk_order', $pk_order)->first();

        return $data;
    }
    function showForTransaction()
    {
        $data = m_order::select(
            'm_orders.pk_order',
            'm_orders.maxusers',
            'm_orders.totalprice',
            'b_periods.period',
            'b_plans.plan'
        )
            ->join('b_plans', 'b_plans.pk_plan', '=', 'm_orders.fk_plan')
            ->join('b_periods', 'b_periods.pk_period', '=', 'm_orders.fk_period')
            ->first();

        return $data;
    }
    function justCreate($fk_user, $fk_product, $fk_plan, $maxusers, $totalprice, $fk_period)
    {
        $data = m_order::create(
            [
                'fk_registrar' => auth()->user()->id,
                'fk_user' => $fk_user,
                'fk_product' => $fk_product,
                'fk_plan' => $fk_plan,
                'fk_period' => $fk_period,
                'maxusers' => $maxusers,
                'totalprice' => $totalprice,
                'paymentmethod' => $totalprice,
            ]
        );

        return $data;
    }
}
