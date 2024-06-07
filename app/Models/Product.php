<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Product::class, 'category_id');
    }

    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}