<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\s_roomevent;

class SRoomeventController extends Controller
{
    use ResponseTrait;

    function eventRequirement(MRoomController $MRoom, UserController $Users)
    {
        $rooms = $MRoom->forCompany();
        $users = $Users->forCompany();

        $res = [
            "rooms" => $rooms,
            "users" => $users,
        ];

        return $res;
    }
    function forCompany()
    {
        $data = s_roomevent::select('pk_roomevent', 'users.name', 'fk_room', 'startdatetime', 'enddatetime')
            ->join('users as registrar', 'registrar.id', '=', 's_roomevents.fk_registrar')
            ->join('users', 'users.id', '=', 's_roomevents.fk_user')
            ->where('registrar.fk_company', auth()->user()->fk_company)
            ->get();

        return $data;
    }
    function companyCreateUpdate(Request $request, MRoomController $MRoom)
    {
        $validated = $request->validate([
            'id' => 'nullable',
            'fk_room' => 'required',
            'fk_user' => 'required',
            'startdatetime' => 'required',
            'enddatetime' => 'required',
        ]);

        $fk_user = $validated['fk_user'];
        $startDateTime = date('Y-m-d H:i:s', strtotime($validated['startdatetime']));
        $endDateTime = date('Y-m-d H:i:s', strtotime($validated['enddatetime']));
        $fk_room = $validated['fk_room'];

        $pk_roomevent = null;
        if (isset($request->id))
            $pk_roomevent = $request->id;

        $hasConflict = $this->checkConfilict($fk_room, $startDateTime, $endDateTime, $pk_roomevent);

        if ($hasConflict)
            return $this->clientErrorResponse("در این بازه زمانی اتاق قبلاً رزرو شده است");

        $room = $MRoom->justShow($validated['fk_room']);
        $maxhoursperweek = $room->maxhoursperweek;
        $roomstarttime = $room->starttime;
        $roomendtime = $room->endtime;

        $userTotalHoursInWeek = $this->userTotalHoursInWeek($fk_user, $startDateTime);

        if ($maxhoursperweek < $userTotalHoursInWeek)
            return $this->clientErrorResponse("سقف ساعت در هفته به پایان رسید به پایان رسیده");

        $eventStartTime = Carbon::parse($startDateTime)->format('H:i:s');
        $eventEndTime = Carbon::parse($endDateTime)->format('H:i:s');

        if ($eventStartTime < $roomstarttime || $eventEndTime > $roomendtime)
            return $this->clientErrorResponse("در محدوده ساعت کاری اتاق انتخاب نمایید");

        s_roomevent::updateOrCreate(
            [
                'pk_roomevent' => $validated['id'] ?? null
            ],
            [
                'fk_room' => $validated['fk_room'],
                'startdatetime' => $startDateTime,
                'fk_registrar' => auth()->user()->id,
                'fk_user' => $fk_user,
                'enddatetime' => $endDateTime,
            ]
        );

        return response()->json(['success' => true, 'maxhoursperweek' => $maxhoursperweek, 'userTotalHoursInWeek' => $userTotalHoursInWeek, 'message' => 'رویداد با موفقیت ذخیره شد']);
    }
    function checkConfilict($fk_room, $startDateTime, $endDateTime, $excludeEventId)
    {
        $query = s_roomevent::where('fk_room', $fk_room)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('startdatetime', [$startDateTime, $endDateTime])
                    ->orWhereBetween('enddatetime', [$startDateTime, $endDateTime])
                    ->orWhere(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('startdatetime', '<=', $startDateTime)
                            ->where('enddatetime', '>=', $endDateTime);
                    });
            });

        if ($excludeEventId) {
            $query->where('pk_roomevent', '!=', $excludeEventId);
        }

        $conflictingEvents = $query->exists();

        return $conflictingEvents;
    }
    function userTotalHoursInWeek($fk_user, $startDateTime)
    {
        $start = Carbon::parse($startDateTime);

        // شروع هفته: شنبه
        $weekStart = $start->copy()->startOfWeek(Carbon::SATURDAY);
        // پایان هفته: جمعه
        $weekEnd = $start->copy()->endOfWeek(Carbon::FRIDAY);

        $events = s_roomevent::where('fk_user', $fk_user)
            ->whereBetween('startdatetime', [$weekStart, $weekEnd])
            ->get();

        $totalHours = 0;
        foreach ($events as $event) {
            $startEvent = Carbon::parse($event->startdatetime);
            $endEvent = Carbon::parse($event->enddatetime);
            $hours = $endEvent->floatDiffInHours($startEvent); // بهتر برای دقت زمانی
            $totalHours += $hours;
        }

        return $totalHours;
    }

    function userCreateUpdate(Request $request, MRoomController $MRoom)
    {
        $validated = $request->validate([
            'id' => 'nullable',
            'fk_room' => 'required',
            'startdatetime' => 'required',
            'enddatetime' => 'required',
        ]);

        $fk_user = auth()->user()->id;
        $startDateTime = date('Y-m-d H:i:s', strtotime($validated['startdatetime']));
        $endDateTime = date('Y-m-d H:i:s', strtotime($validated['enddatetime']));
        $fk_room = $validated['fk_room'];

        $pk_roomevent = null;
        if (isset($request->id))
            $pk_roomevent = $request->id;

        $hasConflict = $this->checkConfilict($fk_room, $startDateTime, $endDateTime, $pk_roomevent);

        if ($hasConflict)
            return $this->clientErrorResponse("در این بازه زمانی اتاق قبلاً رزرو شده است");

        $room = $MRoom->justShow($validated['fk_room']);
        $maxhoursperweek = $room->maxhoursperweek;
        $roomstarttime = $room->starttime;
        $roomendtime = $room->endtime;

        $userTotalHoursInWeek = $this->userTotalHoursInWeek($fk_user, $startDateTime);

        if ($maxhoursperweek < $userTotalHoursInWeek)
            return $this->clientErrorResponse("سقف ساعت در هفته به پایان رسید به پایان رسیده");

        $eventStartTime = Carbon::parse($startDateTime)->format('H:i:s');
        $eventEndTime = Carbon::parse($endDateTime)->format('H:i:s');

        if ($eventStartTime < $roomstarttime || $eventEndTime > $roomendtime)
            return $this->clientErrorResponse("در محدوده ساعت کاری اتاق انتخاب نمایید");

        s_roomevent::updateOrCreate(
            [
                'pk_roomevent' => $validated['id'] ?? null
            ],
            [
                'fk_room' => $validated['fk_room'],
                'startdatetime' => $startDateTime,
                'fk_registrar' => auth()->user()->id,
                'fk_user' => $fk_user,
                'enddatetime' => $endDateTime,
            ]
        );

        return response()->json(['success' => true, 'maxhoursperweek' => $maxhoursperweek, 'userTotalHoursInWeek' => $userTotalHoursInWeek, 'message' => 'رویداد با موفقیت ذخیره شد']);
    }

    function userDelete(Request $request)
    {
        $id = $request->id;

        s_roomevent::destroy($id);
    }
    function comapnyDelete(Request $request)
    {
        $id = $request->id;

        s_roomevent::destroy($id);
    }
}
