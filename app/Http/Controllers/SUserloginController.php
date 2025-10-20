<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\s_userlogin;
use function Laravel\Prompts\select;

class SUserloginController extends Controller
{
    function index()
    {
        $data = s_userlogin::join('users', 'users.id', '=', 's_userlogins.fk_user')
            ->select(
                's_userlogins.pk_userlogin',
                DB::raw("CONCAT(users.name,' ',users.lastname) userfullname"),
                DB::raw("SUBSTR(s_userlogins.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(s_userlogins.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(s_userlogins.created_at, 1, 10)) as jalalicreateddate"),
            )
            ->where('users.fk_company', auth()->user()->id)
            ->orderBy('s_userlogins.pk_userlogin', 'DESC')
            ->get();

        return $data;
    }
    function create($request, $logintype)
    {
        $array = [
            "logintype" => $logintype,
            "ipaddress" => $_SERVER['REMOTE_ADDR'],
            "device" => $request->header('User-Agent'),
            "domain" => $_SERVER['HTTP_REFERER'],
        ];

        $create = s_userlogin::create($array);

        return $create->pk_userlogin;
    }
    function update($pk_userlogin, $issuccess = null, $failreason = null, $fk_user = null)
    {
        s_userlogin::where('pk_userlogin', $pk_userlogin)->update(
            [
                "fk_user" => $fk_user,
                "failreason" => $failreason,
                "issuccess" => $issuccess,
            ]
        );
    }
}
