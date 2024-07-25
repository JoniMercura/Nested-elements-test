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
    public function create() {
        // Create a product type
        $type = Type::create(['name' => 'Electronics']);

        // Create a category an subcategory
        $category = Category::create(['name' => 'Smartphones']);
        $subcategory = Category::create(['name' => 'iPhones', 'parent_id' => $category->id]);

        // Create a property
        $property = Property::create(['name' => 'Color', 'type' => 'string']);

        // Create an assembly
        $assembly = Assembly::create(['name' => 'Main Assembly']);
        $part = Part::create(['name' => 'Battery', 'assembly_id' => $assembly->id]);

        // Create products
        $parentProduct = Product::create([
            'name' => 'iPhone',
            'description' => 'Apple smartphone',
            'price' => 999.99,
            'cost_price' => 799.99,
            'number' => 100,
            'type_id' => $type->id,
            'assembly_id' => $assembly->id
        ]);

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

        $grandChildProduct = Product::create([
            'name' => 'iPhone Mini Pro',
            'description' => 'Pro version of iPhone Mini',
            'price' => 799.99,
            'cost_price' => 699.99,
            'number' => 30,
            'type_id' => $type->id,
            'parent_id' => $childProduct->id,
            'assembly_id' => $assembly->id
        ]);

        $siblingProduct = Product::create([
            'name' => 'iPhone Mini Plus',
            'description' => 'Larger version of iPhone Mini',
            'price' => 499.99,
            'cost_price' => 699.99,
            'number' => 40,
            'type_id' => $type->id,
            'assembly_id' => $assembly->id,
            'parent_id' => $parentProduct->id
        ]);

        // Asign category to the parent product
        $parentProduct->categories()->attach($subcategory->id);

        // Create an attribute and asign to the parent product
        Attribute::create([
            'name' => 'Color',
            'value' => 'Black',
            'order' => 1,
            'property_id' => $property->id,
            'product_id' => $parentProduct->id
        ]);

        return "Products created successfully!";
    }


    public function show($id) {
        $product = Product::with([
            'type',
            'categories',
            'attributes.property',
            'assembly.parts',
            'children'
        ])->find($id);

        return response()->json($product);
    }

    public function testRecursiveRelationships() {
        // Get descendants of a product
        $product = Product::with('descendants')->find(12); 
        $productDescendants = $product->descendants;

        // Get ancestors
        $productWithAncestors = Product::with('ancestors')->find(14); 
        $productAncestors = $productWithAncestors->ancestors;

        // Get siblings
        $productWithSiblings = Product::with('siblings')->find(13); 
        $productSiblings = $productWithSiblings->siblings;

        // Get root ancestor
        $productWithRootAncestor = Product::find(14);  
        $rootAncestor = $productWithRootAncestor->rootAncestor;

        return response()->json([
            'product' => $product,
            'descendants' => $productDescendants,
            'ancestors' => $productAncestors,
            'siblings' => $productSiblings,
            'rootAncestor' => $rootAncestor
        ]);
    }

    public function tree() {
        // Get full tree
        $tree = Product::tree()->get();

        return response()->json(['tree' => $tree]);
    }

    public function testAdditionalMethods($childId, $parentId) {
        $child = Product::find($childId);
        $parent = Product::find($parentId);

        $isChildOf = $child->isChildOf($parent);
        $isParentOf = $parent->isParentOf($child);
        $depthRelatedTo = $child->getDepthRelatedTo($parent);

        return response()->json([
            'is_child_of' => $isChildOf,
            'is_parent_of' => $isParentOf,
            'depth_related_to' => $depthRelatedTo
        ]);
    }
}
