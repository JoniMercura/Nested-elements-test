<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Option;
use App\Models\Element;

class GroupController extends Controller
{
    public function init()
    {
       

        // element
        $ele1 = Element::create([
            'name' => 'shape',
            'text' => 'The shapes',
            'type' => 'radio',
            'price_formula' => 'null',
            'item_number_formula' => 'null',
            'generates_products' => false,
            'default' => 'null',
        ]);
        $ele2 = Element::create([
            'name' => 'Color',
            'text' => 'Choose color',
            'type' => 'radio',
            'price_formula' => 'null',
            'item_number_formula' => 'null',
            'generates_products' => false,
            'default' => 'null',
        ]);
        $ele3 = Element::create([
            'name' => 'Size',
            'text' => 'Choose size',
            'type' => 'radio',
            'price_formula' => 'null',
            'item_number_formula' => 'null',
            'generates_products' => false,
            'default' => 'null',
        ]);

         // shapes
         $opt1 = Option::create([
            'name' => 'Half Round',
            'text' => 'Half Round',
            'price' => 100,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele1->id,
        ]);
        $opt2 = Option::create([
            'name' => 'Quarter round',
            'text' => 'Quarter round',
            'price' => 50,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele1->id,
        ]);

        // Colors
        $opt3 = Option::create([
            'name' => 'Dark Silver',
            'text' => 'Dark Silver',
            'price' => 10,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele2->id,
        ]);
        
        $opt4 = Option::create([
            'name' => 'Antracit',
            'text' => 'Antracit',
            'price' => 5,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele2->id,
        ]);

        

        // Sizes
        $opt5 = Option::create([
            'name' => '100 mm',
            'text' => '100 mm',
            'price' => 100,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele3->id,
        ]);
        
        $opt6 = Option::create([
            'name' => '150 mm',
            'text' => '150mm',
            'price' => 150,
            'quantity' => 1,
            'show_quantity' => false,
            'default_selected' => false,
            'default_quantity' => 1,
            'element_id' => $ele3->id,
        ]);

        
        
        $ele4 = Element::create([
            'name' => 'Gutter',
            'text' => 'Gutter',
            'type' => 'nested',
            'price_formula' => '{shape.price}+{color.price}+{size.price}',
            'item_number_formula' => '{shape.number}-{color.number}-{size.number}',
            'generates_products' => true,
            'default' => 'null',
        ]);

        $group = Group::create([
            'name' => 'Gutter',
        ]);


        $ele4->children()->saveMany([$ele1, $ele2, $ele3]);

        // Create group and attach elements
        $group->elements()->save($ele4);

        return Group::with('elements.children')->get();
    }
}
