<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;

class ExcelImportController extends Controller
{
    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xls');
    }
}
