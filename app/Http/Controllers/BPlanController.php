<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\b_plan;

class BPlanController extends Controller
{
    function show(Request $request)
    {
        $planId = $request->planID;

        return $this->justShow($planId);
    }
    function justShow($pk_plan)
    {
        $data = b_plan::where('pk_plan', $pk_plan)->first();

        return $data;
    }
    function index()
    {
        $data = b_plan::where('istrial', 0)->get();

        return $data;
    }
}
