<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Product;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index()
    {
        $all_calendars = Calendar::with('product')->get();
        $products = Product::with('tariffs')->get();
        $calendars = [];
        foreach ($all_calendars as $calendar) {
            $calendars[] = [
                'title' => $calendar->quantity . ' ' . $calendar->product->name . ': ' . $calendar->price . '€',
                'start' => $calendar->order_date,
                'end' => $calendar->order_date,
            ];
        }
        return view("calendar.index", compact('calendars'));
    }

    public function create(Request $request)
    {
        $date = Carbon::parse($request->date);
        $calendars = Calendar::whereDate('order_date', $date)->get();

        $products = Product::whereHas('tariffs', function ($query) use ($date) {
            $query->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date);
        })->get();
        $productsWithOrders = collect();

        foreach ($products as $product) {
            if ($calendars->contains('product_id', $product->id)) {
                $productsWithOrders->push($product);
            }
        }

        return view('calendar.editCreate', compact(['productsWithOrders', 'date', 'products', 'calendars']));
    }


    public function store(Request $request)
    {
        $request->validate([
            'products*' => 'filled',
            'quantity*' => 'required'
        ]);

        $products = $request->products;
        $quantities = $request->quantity;

        if ($quantities === null) {
            Calendar::whereDate('order_date', $request->date)->delete();
            return redirect()->route('calendar.index')->with('success', 'Order created successfully!');
        }

        if (in_array(null, $quantities)) {
            return redirect()->back()->with('error', 'Quantity cannot be null.');
        }

        Calendar::whereDate('order_date', $request->date)->delete();

        foreach ($products as $key => $productId) {
            $product = Product::find($productId);

            $quantity = $quantities[$key];

            $tariff = Tariff::where('product_id', $product->id)
                ->whereDate('start_date', '<=', $request->date)
                ->whereDate('end_date', '>=', $request->date)
                ->first();

            $calendar = new Calendar();
            $calendar->order_date = $request->date;
            $calendar->product_id = $product->id;
            $calendar->quantity = $quantity;
            $calendar->price = $tariff->price * $quantity;
            $calendar->save();
        }

        return redirect()->route('calendar.index')->with('success', 'Order created successfully!');
    }
}
