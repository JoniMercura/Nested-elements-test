<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Assembly;
use App\Models\Part;
use App\Models\Type;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Property;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        // Crear un tipo de producto
        $type = Type::create(['name' => 'Electronics']);

        // Crear una categoría principal
        $category = Category::create(['name' => 'Smartphones']);

        // Crear una subcategoría
        $subcategory = Category::create(['name' => 'iPhones', 'parent_id' => $category->id]);

        // Crear una propiedad
        $property = Property::create(['name' => 'Color', 'type' => 'string']);

        // Crear un assembly
        $assembly = Assembly::create(['name' => 'Main Assembly']);

        // Crear una parte y asignarla al assembly
        $part = Part::create([
            'name' => 'Battery',
            'assembly_id' => $assembly->id
        ]);

        // Crear un producto raíz
        $parentProduct = Product::create([
            'name' => 'iPhone',
            'description' => 'Apple smartphone',
            'price' => 999.99,
            'cost_price' => 799.99,
            'number' => 100,
            'type_id' => $type->id,
            'assembly_id' => $assembly->id
        ]);

        // Crear un producto hijo
        $childProduct = Product::create([
            'name' => 'iPhone Mini',
            'description' => 'Smaller version of Apple smartphone',
            'price' => 699.99,
            'cost_price' => 599.99,
            'number' => 50,
            'type_id' => $type->id,
            'parent_id' => $parentProduct->id,
            'assembly_id' => $assembly->id
        ]);

        // Asignar categoría al producto raíz
        $parentProduct->categories()->attach($subcategory->id);

        // Crear un atributo y asignarlo al producto raíz
        Attribute::create([
            'name' => 'Color',
            'value' => 'Black',
            'order' => 1,
            'property_id' => $property->id,
            'product_id' => $parentProduct->id
        ]);

        return "Product created successfully!";
    }

    public function show($id)
    {
        $product = Product::with([
            'type',
            'categories',
            'attributes.property',
            'assembly.parts',
            'children'
        ])->find($id);

        return response()->json($product);
    }
}
