<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    protected $fillable = ['name'];

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
