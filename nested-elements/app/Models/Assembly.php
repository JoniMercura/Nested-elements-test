<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasGraphRelationships;


class Assembly extends Model
{
    use HasGraphRelationships;


    protected $fillable = ['name'];


    public function getPivotTableName(): string
    {
        return 'assembly_assembly';
    }

    public function getPivotColums()
    {
        return ['quantity'];
    }
    
    public function enableCycleDetection(): bool
    {
        return true;
    }

    public function assemblies()
    {
        return $this->descendants()->withTimestamps();
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class)->withPivot('quantity')->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
