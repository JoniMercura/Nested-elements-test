<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use App\Models\Group;
use App\Models\InputRule;
use App\Models\ProductSelector;
use App\Models\Option;

class Element extends Model
{
    use HasRecursiveRelationships;
    use HasFactory;

    protected $fillable = [
        'name', 
        'text',
        'type',
        'price_formula',
        'item_number_formula',
        'generates_products',
        'default',
        'parent_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function inputRules()
    {
        return $this->belongsToMany(InputRule::class)->withPivot('value');
    }

    public function productSelector()
    {
        return $this->hasOne(ProductSelector::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function elements()
    {
        return $this->children();
    }
}
