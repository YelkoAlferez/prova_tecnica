<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Función para asignar imagenes a un producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    use HasFactory;
}
