<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Product extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = ['name', 'description', 'price', 'cost_price', 'number', 'type_id', 'assembly_id', 'parent_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function assembly()
    {
        return $this->belongsTo(Assembly::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }
}
