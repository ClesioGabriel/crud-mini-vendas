<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];


    public function getPriceAttribute($value)
    {
        return (float) $value; // Garante que o valor retornado seja sempre um float
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) $value; // Garante que o valor salvo seja um float
    }
}