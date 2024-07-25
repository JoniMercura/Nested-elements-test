<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Element;
use App\Models\Product;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text',
        'price',
        'quantity',
        'show_quantity',
        'default_selected',
        'default_quantity',
        'element_id',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function product()
    {
        $this->belongsToMany(Product::class);
    }
}
