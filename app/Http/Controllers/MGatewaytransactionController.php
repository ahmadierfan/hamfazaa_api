<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\m_gatewaytransaction;

class MGatewaytransactionController extends Controller
{
    function justCreate($orderID, $amount, $authority)
    {
        $data = m_gatewaytransaction::create([
            'fk_registrar' => auth()->user()->id,
            'fk_order' => $orderID,
            'authority' => $authority,
            'fk_paymentstatus' => 1,
            'amount' => $amount,
        ]);

        return $data;
    }
    function udpateTransaction($authority, $fk_paymentstatus)
    {
        m_gatewaytransaction::where('authority', $authority)
            ->update([
                'fk_paymentstatus' => $fk_paymentstatus
            ]);
    }
    function showWithAuthority($Authority)
    {
        $data = m_gatewaytransaction::where('authority', $Authority)->first();

        return $data;
    }
}
