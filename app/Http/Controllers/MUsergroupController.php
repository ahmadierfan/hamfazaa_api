<?php

namespace App\Http\Controllers;

use App\Models\m_usergroup;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class MUsergroupController extends Controller
{
    function forCompany()
    {
        if (isset(auth()->user()->fk_company)) {
            $data = m_usergroup::select(
                'm_usergroups.pk_usergroup',
                'm_usergroups.usergroup',
                'm_usergroups.description',
                DB::raw("SUBSTR(m_usergroups.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(m_usergroups.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(m_usergroups.created_at, 1, 10)) as jalalicreateddate")
            )
                ->join('users', 'users.id', '=', 'm_usergroups.fk_registrar')
                ->where('users.fk_company', auth()->user()->fk_company)
                ->get();

            return $data;
        }
    }
    function createUpdate(Request $request)
    {
        $validated = $request->validate([
            'pk_usergroup' => 'nullable',
            'usergroup' => 'required|string',
            'description' => 'string',
        ]);

        $validated['fk_registrar'] = auth()->user()->id;

        m_usergroup::updateOrCreate(
            [
                'pk_usergroup' => $validated['pk_usergroup'] ?? null
            ],
            $validated
        );
    }

    function delete(Request $request)
    {
        $groupId = $request->groupId;
        m_usergroup::destroy($groupId);
    }
}
