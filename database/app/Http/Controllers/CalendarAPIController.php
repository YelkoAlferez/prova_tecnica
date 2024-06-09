<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Carbon\Carbon;

class CalendarAPIController extends Controller
{
    /**
     * Función para retornar los pedidos, en caso de no haber, muestra que no hay pedidos
     */
    public function index()
    {
        $calendars = Calendar::with('product')->get();
        if($calendars === null){
            return response()->json([
                "No orders found"
            ]);
        }
        return response()->json([
            $calendars
        ]);
    }

    /**
     * Función para retornar los pedidos de una fecha, en caso de no haber, muestra que no hay pedidos en esa fecha
     */
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
