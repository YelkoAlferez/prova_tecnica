<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Product;
use App\Models\Tariff;
use Carbon\Carbon;
use Throwable;

class CalendarAPIController extends Controller
{
    /**
     * Función para retornar los pedidos, en caso de no haber, muestra que no hay pedidos
     */
    public function index()
    {
        $calendars = Calendar::with('product')->get();
        if ($calendars === null) {
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

    /**
     * Función para guardar un pedido
     */
    public function update(Request $request)
    {
        try {
            // Comprobamos los campos
            $request->validate([
                'products*' => 'filled',
                'quantity*' => 'required'
            ]);

            $products = $request->products;
            $quantities = $request->quantity;

            // Si se envia vacío, se borran los datos y se devuelve a la vista
            if ($quantities === null) {
                Calendar::whereDate('order_date', $request->date)->delete();
                return redirect()->route('calendar.index')->with('success', 'Order created successfully!');
            }

            // Si existe algun campo cantidad null, significa que se ha marcado un producto pero no se ha especificado la cantidad, 
            // por tanto se devuelve al formulario con un mensaje de error
            if (in_array(null, $quantities)) {
                return redirect()->back()->with('error', 'Quantity cannot be null.');
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

            return response()->json([
                'The order has been saved'
            ]);
        } catch (Throwable) {
            return response()->json([
                'The order has not been saved'
            ]);
        }
    }
}
