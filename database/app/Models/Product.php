<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;
    
    /**
     * Función para asignar categorías a un producto
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    /**
     * Función para asignar imagenes a un producto
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Función para asignar tarifas a un producto
     */
    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
}