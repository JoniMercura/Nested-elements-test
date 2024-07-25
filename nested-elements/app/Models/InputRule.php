<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Element;

class InputRule extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function elements()
    {
        return $this->belongsToMany(Element::class)->withPivot('value');
    }
}
