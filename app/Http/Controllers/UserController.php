<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Controllers\MCompanyController;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ResponseTrait;
    function showWithColumn($col, $mobile)
    {
        $user = User::where($col, $mobile)->first();

        return $user;
    }
    function showManagerWithMobile($mobile)
    {
        $user = User::where('mobile', $mobile)
            ->where('ismanager', 1)
            ->first();

        return $user;
    }
    function forCompany()
    {
        if (isset(auth()->user()->fk_company)) {
            $data = User::select(
                'users.id',
                'users.name',
                'users.lastname',
                'users.mobile',
                'users.isactive',
                DB::raw("SUBSTR(users.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(users.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(users.created_at, 1, 10)) as jalalicreateddate")
            )
                ->where('fk_company', auth()->user()->fk_company)
                ->get();

            return $data;
        }
    }

    function userCreateWithMobile($mobile, $name)
    {
        $MCompany = new MCompanyController();

        $fk_company = $MCompany->companyCreator();

        $final = [
            'name' => $name,
            'mobile' => $mobile,
            'fk_registrar' => 1,
            'fk_company' => $fk_company,
        ];

        $user = User::create($final);

        return $user;
    }
    function managerCreateWithMobile($mobile, $name)
    {
        $MCompany = new MCompanyController();

        $fk_company = $MCompany->companyCreator();

        $final = [
            'name' => $name,
            'mobile' => $mobile,
            'fk_registrar' => 1,
            'fk_company' => $fk_company,
            'ismanager' => 1,
        ];

        $user = User::create($final);

        return $user;
    }
    function createUpdate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'mobile' => 'required|string',
        ]);

        User::updateOrCreate(
            [
                "mobile" => $validated['mobile'],
                "fk_company" => auth()->user()->fk_company
            ],
            [
                "mobile" => $validated['mobile'],
                'name' => $validated['name'],
                'lastname' => $validated['lastname'],
                "fk_company" => auth()->user()->fk_company
            ]
        );
    }
    function delete(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required',
        ]);

        $userId = $request->userId;

        $user = $this->showWithColumn('id', $userId);

        if ($user->fk_company != auth()->user()->fk_company)
            return $this->clientErrorResponse("Company??");

        User::destroy($userId);
    }
}
