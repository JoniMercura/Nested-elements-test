<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['name', 'assembly_id'];

    public function assemblies()
    {
        return $this->belongsToMany(Assembly::class)->withPivot('quantity')->withTimestamps();
    }
}

