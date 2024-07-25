<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Element;

class ProductSelector extends Model
{
    use HasFactory;

    protected $fillable = ['method','query'];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
