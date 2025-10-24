<?php

namespace App\Http\Controllers;

use App\Models\m_wallettransaction;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class MWallettransactionController extends Controller
{

    //company
    function updateTransactionStatus(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
        ]);

        $transactionId = $request->transaction_id;

        m_wallettransaction::where('pk_wallettransaction', $transactionId)
            ->update([
                'ispayed' => 1,
                'fk_confirmer' => auth()->user()->id,
                'confirmdatetime' => now()
            ]);

    }
    function companyTransactions()
    {
        $data = m_wallettransaction::select(
            'm_wallettransactions.*',
            'users.mobile',
            DB::raw("SUBSTR(m_wallettransactions.created_at, 1, 10) as createddate"),
            DB::raw("SUBSTR(m_wallettransactions.created_at, 12, 5) as createdtime"),
            DB::raw("pdate(SUBSTR(m_wallettransactions.created_at, 1, 10)) as jalalicreateddate"),
        )
            ->join('users', 'users.id', '=', 'm_wallettransactions.fk_registrar')
            ->where('users.fk_company', auth()->user()->fk_company)
            ->orderBy('m_wallettransactions.pk_wallettransaction', 'DESC')
            ->get();

        return $data;
    }
    function companyIncrease(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
            'userid' => 'required|integer',
            'description' => 'string|nullable',
        ]);

        $amount = $request->amount;
        $userid = $request->userid;
        $description = $request->description;

        $this->justCreate($amount, $userid, $description, $request, 1);

    }

    //users
    function userBallance($fk_user)
    {
        $sum = m_wallettransaction::where('fk_user', $fk_user)
            ->where('ispayed', 1)
            ->sum('amount');

        return $sum;
    }
    function decreaseForReserve($fk_user, $reserveAmount)
    {
        $this->justCreate(-$reserveAmount, $fk_user, null, null, 1);
    }
    function userTransactions()
    {

        $data = m_wallettransaction::select(
            'm_wallettransactions.*',
            DB::raw("SUBSTR(m_wallettransactions.created_at, 1, 10) as createddate"),
            DB::raw("SUBSTR(m_wallettransactions.created_at, 12, 5) as createdtime"),
            DB::raw("pdate(SUBSTR(m_wallettransactions.created_at, 1, 10)) as jalalicreateddate"),
        )
            ->where('fk_user', auth()->user()->id)
            ->orderBy('m_wallettransactions.pk_wallettransaction', 'DESC')
            ->get();

        return $data;
    }
    function userIncrease(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
            'description' => 'string|nullable'
        ]);

        $amount = $request->amount;
        $description = $request->description;
        $userid = auth()->user()->id;

        $walletTransaction = $this->justCreate($amount, $userid, $description, $request, 0);
    }

    //public
    function justCreate($amount, $userid, $description, $request, $ispayed)
    {
        $fk_registrar = auth()->check() ? auth()->id() : null;


        $imagePath = null;
        if ($request != null && $request->hasFile('attachment')) {
            $request->validate([
                'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

            $filename = time() . '-' . uniqid() . '.' . $request->file('attachment')->getClientOriginalExtension();
            $imagePath = $request->file('attachment')->storeAs('images/wallet/attachments', $filename, 'public');
        }

        $create = m_wallettransaction::create([
            'fk_registrar' => $fk_registrar,
            'amount' => $amount,
            'fk_user' => $userid,
            'description' => $description,
            'attachment' => $imagePath,
            'ispayed' => $ispayed,
        ]);

        return $create;

    }
}
