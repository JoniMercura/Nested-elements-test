<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name', 'type'];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}