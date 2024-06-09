<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /**
     * Función para asignar productos a un pedido
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    use HasFactory;
}
