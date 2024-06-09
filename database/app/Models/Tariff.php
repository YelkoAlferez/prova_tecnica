<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    
    /**
     * Función para asignar un producto a una tarifa
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    use HasFactory;
}
