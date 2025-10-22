<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZarinpalController extends Controller
{
    protected $merchant_id = '51e310d8-0d38-4e1c-bb59-05430b15dbb8';

    public function pay($price, $ordernumber)
    {
        // مشخصات تراکنش
        $amount = $price; // مبلغ به ریال
        $callback_url = url('/callback'); // آدرس بازگشت
        $description = (string) $ordernumber;
        $metadata = [];

        // ارسال درخواست به زرین‌پال
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://payment.zarinpal.com/pg/v4/payment/request.json', [
                    'merchant_id' => $this->merchant_id,
                    'amount' => $amount,
                    'callback_url' => $callback_url,
                    'description' => $description,
                    'metadata' => $metadata,
                ]);

        $result = $response->json();

        // بررسی پاسخ
        if (isset($result['data']['code']) && $result['data']['code'] == 100) {
            // انتقال کاربر به درگاه پرداخت
            $authority = $result['data']['authority'];
            $res = [
                "link" => "https://payment.zarinpal.com/pg/StartPay/{$authority}",
                "authority" => $authority
            ];
            return $res;
        } else {
            return response()->json([
                'error' => $result['errors'] ?? 'خطا در ارتباط با زرین‌پال'
            ]);
        }
    }

    public function callback(Request $request)
    {
        $authority = $request->get('Authority');
        $status = $request->get('Status');

        if ($status !== 'OK') {
            $this->cancel($authority);
            header("Location: https://hamfazaa.ir/copanel/paycancel");
            exit();
        } else {
            $this->confirm($authority);
        }

    }
    function confirm($authority)
    {
        $MGatewaytransaction = new MGatewaytransactionController();
        $MSubscription = new MSubscriptionController();

        $transaction = $MGatewaytransaction->showWithAuthority($authority);
        $MGatewaytransaction->udpateTransaction($authority, 2);

        $fk_order = $transaction->fk_order;

        $MSubscription->craete($fk_order);

        $url = 'Location: https://hamfazaa.ir/copanel/paysuccess?orderId=';
        $redirect = $url . $fk_order;

        header($redirect);
        exit();
    }
    function cancel($authority)
    {
        $MGatewaytransaction = new MGatewaytransactionController();
        $MGatewaytransaction->udpateTransaction($authority, 3);
    }
}
