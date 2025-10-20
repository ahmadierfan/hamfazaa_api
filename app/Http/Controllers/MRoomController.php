<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Models\m_room;

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
    function activeRomms()
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
                ->where('m_rooms.isactive', 1)
                ->get();

            return $data;
        }
    }
    function createUpdate(Request $request)
    {
        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate([
            "pk_room" => "nullable|exists:m_rooms,pk_room",
            "room" => "required|string|max:255",
            "capacity" => "required|integer|min:1",
            "starttime" => "required|date_format:H:i",
            "endtime" => "required|date_format:H:i|after:starttime",
            "availabledays" => "required|array",
            "availabledays.*" => "string|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday",
            "maxhoursperuser" => "required|integer|min:1",
            "isactive" => "required",
            "description" => "nullable|string",
            "maxhoursperweek" => "required|integer|min:1",
            "amountperhour" => "required|integer|min:0",
        ]);
        // محاسبه ساعت کاری هفتگی
        $start = \Carbon\Carbon::createFromFormat('H:i', $validated['starttime']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $validated['endtime']);
        $dailyHours = $start->diffInHours($end);
        $weeklyHours = $dailyHours * count($validated['availabledays']);

        // اگر maxhoursperweek ارائه نشده، از مقدار محاسبه شده استفاده کن
        $maxHoursPerWeek = $validated['maxhoursperweek'] ?? $weeklyHours;

        // آماده‌سازی داده‌ها برای ذخیره
        $roomData = [
            'room' => $validated['room'],
            'maxhoursperweek' => $maxHoursPerWeek,
            'amountperhour' => $validated['amountperhour'],
            'fk_company' => auth()->user()->fk_company,
            'fk_registrar' => auth()->user()->id,
            'capacity' => $validated['capacity'],
            'starttime' => $validated['starttime'],
            'endtime' => $validated['endtime'],
            'availabledays' => json_encode($validated['availabledays']),
            'maxhoursperuser' => $validated['maxhoursperuser'],
            'isactive' => $validated['isactive'],
            'description' => $validated['description'] ?? ''
        ];

        // ایجاد یا به‌روزرسانی بر اساس pk_room
        $room = m_room::updateOrCreate(
            [
                'pk_room' => $validated['pk_room'] ?? null
            ],
            $roomData
        );
    }
    function delete(Request $request)
    {
        $roomId = $request->roomId;

        m_room::destroy($roomId);
    }
}
