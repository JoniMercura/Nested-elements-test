<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['name', 'assembly_id'];

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }
}

