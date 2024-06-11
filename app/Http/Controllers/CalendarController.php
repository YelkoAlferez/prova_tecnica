<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarPostRequest;
use App\Models\Calendar;
use App\Models\Product;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    /**
     * Función para mostrar los pedidos, pasandole como datos la cantidad, el nombre del producto y el precio del pedido
     */
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

    /**
     * Función para crear un pedido o editarlo, busco los pedidos en esa fecha y todos los productos que contienen esa fecha en algún período de tarifa
     */
    public function create(Request $request)
    {
        $date = Carbon::parse($request->date);
        $calendars = Calendar::whereDate('order_date', $date)->get();

        $products = Product::whereHas('tariffs', function ($query) use ($date) {
            $query->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date);
        })->get();
        

        // Creamos una coleccion para almacenar los productos que se encuentran en un pedido en esa fecha

        $productsWithOrders = collect();
        foreach ($products as $product) {
            if ($calendars->contains('product_id', $product->id)) {
                $productsWithOrders->push($product);
            }
        }

        return view('calendar.editCreate', compact(['productsWithOrders', 'date', 'products', 'calendars']));
    }


    /**
     * Función para guardar un pedido
     */
    public function store(CalendarPostRequest $request) : RedirectResponse
    {
        // Comprobamos los campos
        $validated = $request->validated();

        $products = $request->products;
        $quantities = $request->quantity;

        // Si se envia vacío, se borran los datos y se devuelve a la vista
        if ($quantities === null) {
            Calendar::whereDate('order_date', $request->date)->delete();
            return redirect()->route('calendar.index')->with('success', 'Order created successfully!');
        }

        // Borramos los pedidos en esa fecha
        Calendar::whereDate('order_date', $request->date)->delete();

        // Creamos un index valor para poder asignar las cantidades a sus respectivos productos
        foreach ($products as $key => $productId) {
            $product = Product::find($productId);

            $quantity = $quantities[$key];

            // Cogemos la primera tarifa aplicada a ese producto, es decir, la más reciente
            $tariff = Tariff::where('product_id', $product->id)
                ->whereDate('start_date', '<=', $request->date)
                ->whereDate('end_date', '>=', $request->date)
                ->first();

            // Creamos el pedido y lo guardamos
            $calendar = new Calendar();
            $calendar->order_date = $request->date;
            $calendar->product_id = $product->id;
            $calendar->quantity = $quantity;
            $calendar->price = $tariff->price * $quantity;
            $calendar->save();
        }

        // Devolvemos a la vista
        return redirect()->route('calendar.index')->with('success', 'Order created successfully!');
    }
}
