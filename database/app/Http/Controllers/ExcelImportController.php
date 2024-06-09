<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;

class ExcelImportController extends Controller
{
    /**
     * Función para exportar un xls de los productos
     */
    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xls');
    }
}
