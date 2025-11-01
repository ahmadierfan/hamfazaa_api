<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\m_room;
use App\Models\r_usergrouproom;


class MRoomController extends Controller
{

    function forCompany()
    {
        if (isset(auth()->user()->fk_company)) {
            $data = m_room::select(
                'm_rooms.*',
                DB::raw("SUBSTR(users.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(users.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(users.created_at, 1, 10)) as jalalicreateddate")
            )
                ->join('users', 'users.id', '=', 'm_rooms.fk_registrar')
                ->where('users.fk_company', auth()->user()->fk_company)
                ->get();

            return $data;
        }
    }
    function justShow($pk_room)
    {
        $data = m_room::where('pk_room', $pk_room)->first();
        return $data;
    }
    function activeRomms(MUsergroupController $MUsergroup)
    {
        if (isset(auth()->user()->fk_company)) {
            $userGroups = $MUsergroup->forCompany();

            $rooms = m_room::select(
                'm_rooms.*',
                DB::raw("SUBSTR(users.created_at, 1, 10) as createddate"),
                DB::raw("SUBSTR(users.created_at, 12, 5) as createdtime"),
                DB::raw("pdate(SUBSTR(users.created_at, 1, 10)) as jalalicreateddate")
            )
                ->join('users', 'users.id', '=', 'm_rooms.fk_registrar')
                ->where('users.fk_company', auth()->user()->fk_company)
                ->where('m_rooms.isactive', 1)
                ->get();

            // اضافه کردن اطلاعات گروه‌های کاربری مربوط به هر اتاق
            $rooms->each(function ($room) {
                $room->userGroups = r_usergrouproom::where('fk_room', $room->pk_room)
                    ->join('m_usergroups', 'm_usergroups.pk_usergroup', '=', 'r_usergrouprooms.fk_usergroup')
                    ->select(
                        'r_usergrouprooms.*',
                        'm_usergroups.usergroup'
                    )
                    ->get()
                    ->toArray();
            });

            $res = [
                "rooms" => $rooms,
                "userGroups" => $userGroups,
            ];

            return $res;
        }
    }

    function createUpdate(Request $request, RUsergrouproomController $RUsergrouproom)
    {
        DB::beginTransaction();
        try {

            // اعتبارسنجی داده‌های ورودی
            $validated = $request->validate([
                "pk_room" => "nullable|exists:m_rooms,pk_room",
                "room" => "required|string|max:255",
                "capacity" => "required|integer|min:1",
                "starttime" => "required|date_format:H:i",
                "endtime" => "required|date_format:H:i|after:starttime",
                "availabledays" => "required|array",
                "availabledays.*" => "string|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday",
                "isactive" => "required",
                "description" => "nullable|string",
            ]);

            // آماده‌سازی داده‌ها برای ذخیره
            $roomData = [
                'room' => $validated['room'],
                'fk_registrar' => auth()->user()->id,
                'capacity' => $validated['capacity'],
                'starttime' => $validated['starttime'],
                'endtime' => $validated['endtime'],
                'availabledays' => json_encode($validated['availabledays']),
                'isactive' => $validated['isactive'],
                'description' => $validated['description'] ?? ''
            ];

            // ایجاد یا به‌روزرسانی بر اساس pk_room
            $data = m_room::updateOrCreate(
                [
                    'pk_room' => $validated['pk_room'] ?? null
                ],
                $roomData
            );
            $pk_room = $data->pk_room;

            $dataForInsert = [];

            $userGroups = $request->userGroups;
            foreach ($userGroups as $value) {
                $newData['fk_registrar'] = auth()->user()->id;
                $newData['fk_usergroup'] = $value['pk_usergroup'];
                $newData['amountperhour'] = $value['amountperhour'];
                $newData['maxhoursperweek'] = $value['maxhoursperweek'];
                $newData['fk_room'] = $pk_room;
                $newData['created_at'] = now();
                $newData['updated_at'] = now();

                array_push($dataForInsert, $newData);
            }
            $RUsergrouproom->updateCreate($pk_room, $dataForInsert);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    function delete(Request $request)
    {
        $roomId = $request->roomId;

        m_room::destroy($roomId);
    }
}
