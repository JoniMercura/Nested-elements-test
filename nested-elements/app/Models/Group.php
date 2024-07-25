<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use App\Models\Element;

class Group extends Model
{
    use HasRecursiveRelationships;
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function elements()
    {
        return $this->hasMany(Element::class);
    }
}
