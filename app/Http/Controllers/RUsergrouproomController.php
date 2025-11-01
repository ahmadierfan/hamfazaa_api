<?php

namespace App\Http\Controllers;

use App\Models\r_usergrouproom;
use Illuminate\Support\Facades\DB;


class RUsergrouproomController extends Controller
{
    function updateCreate($fk_room, $dataForInsert)
    {
        r_usergrouproom::where('fk_room', $fk_room)->delete();

        r_usergrouproom::insert($dataForInsert);
    }

    function getRoomDataForUser($fk_room, $fk_user)
    {
        $result = DB::table('r_usergrouprooms')
            ->join('r_userusergroups', 'r_userusergroups.fk_usergroup', '=', 'r_usergrouprooms.fk_usergroup')
            ->where('r_userusergroups.fk_user', $fk_user)
            ->where('r_usergrouprooms.fk_room', $fk_room)
            ->select(
                'r_usergrouprooms.maxhoursperweek',
                'r_usergrouprooms.amountperhour',
                'r_usergrouprooms.fk_room',
                'r_usergrouprooms.fk_usergroup'
            )
            ->first();

        return $result;

    }
}
