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
        $MUsergroup = new MUsergroupController();
        if (isset(auth()->user()->fk_company)) {
            $userGroups = $MUsergroup->forCompany();

            $users = User::select(
                'users.id',
                'users.name',
                'users.mobile',
                'users.isactive',
                DB::raw("SUBSTR(users.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(users.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(users.created_at, 1, 10)) as jalalicreateddate")
            )
                ->where('fk_company', auth()->user()->fk_company)
                ->get();

            // اضافه کردن اطلاعات گروه‌های کاربری برای هر کاربر
            $users->each(function ($user) {
                $user->userusergroup = DB::table('r_userusergroups')
                    ->where('fk_user', $user->id)
                    ->pluck('fk_usergroup')
                    ->toArray();
            });

            $res = [
                'userGroups' => $userGroups,
                'users' => $users,
            ];

            return $res;
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
    function createUpdate(Request $request, RUserusergroupController $RUserusergroup)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'mobile' => 'required|string',
                'isactive' => 'sometimes|integer|in:0,1',
                'userusergroup' => 'array',
            ]);

            $updateData = [
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                "fk_company" => auth()->user()->fk_company
            ];

            // اگر isactive ارسال شده باشد، آن را هم اضافه کنید
            if (isset($validated['isactive'])) {
                $updateData['isactive'] = $validated['isactive'];
            }

            $data = User::updateOrCreate(
                [
                    "mobile" => $validated['mobile'],
                    "fk_company" => auth()->user()->fk_company
                ],
                $updateData
            );
            $fk_user = $data->id;


            $userusergroup = $request->userusergroup;
            if (count($request->userusergroup) != 0) {
                $dataForInsert = [];
                foreach ($userusergroup as $value) {
                    $newData['fk_registrar'] = auth()->user()->id;
                    $newData['fk_usergroup'] = $value;
                    $newData['fk_user'] = $fk_user;
                    $newData['created_at'] = now();
                    $newData['updated_at'] = now();

                    array_push($dataForInsert, $newData);
                }

                $RUserusergroup->updateCreate($fk_user, $dataForInsert);
            } else
                $RUserusergroup->deleteByUser($fk_user);



            DB::commit();

            return response()->json(['success' => true, 'message' => 'کاربر با موفقیت ذخیره شد']);
        } catch (\Exception $e) {
            DB::rollBack();
        }
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
