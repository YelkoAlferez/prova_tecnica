<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Carbon\Carbon;

class CalendarAPIController extends Controller
{
    public function index()
    {
        $calendars = Calendar::with('product')->get();
        return response()->json([
            $calendars
        ]);
    }

    public function edit(Request $request)
    {
        $date = Carbon::parse($request->date);
        $calendars = Calendar::whereDate('order_date', $date)->get();

        if (count($calendars) > 0) {
            return response()->json([
                $calendars
            ]);
        } else {
            return response()->json([
                "No orders found at " . $request->date
            ]);
        }
    }
}
