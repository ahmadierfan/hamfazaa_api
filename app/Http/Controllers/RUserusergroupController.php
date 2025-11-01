<?php

namespace App\Http\Controllers;

use App\Models\r_userusergroup;

class RUserusergroupController extends Controller
{
    function updateCreate($fk_user, $dataForInsert)
    {
        r_userusergroup::where('fk_user', $fk_user)->delete();

        r_userusergroup::insert($dataForInsert);
    }
    function deleteByUser($fk_user)
    {
        r_userusergroup::where('fk_user', $fk_user)->delete();
    }
}
