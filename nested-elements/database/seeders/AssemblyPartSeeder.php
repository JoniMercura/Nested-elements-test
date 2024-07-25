<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Part;
use App\Models\Assembly;
use App\Models\Product;

class AssemblyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p1 = Part::create([
            'name' => 'Part 1',
        ]);
        $p2 = Part::create([
            'name' => 'Part 2',
        ]);
        $p3 = Part::create([
            'name' => 'Part 3',
        ]);

        // Assemblies
        $a1 = Assembly::create([
            'name' => 'Assembly 1',
        ]);
        
        $a2 = Assembly::create([
            'name' => 'Assembly 2',
        ]);
        $a3 = Assembly::create([
            'name' => 'Assembly 3',
        ]);
        

        // PARTS
        $a1->parts()->attach($p1->id, ['quantity' => 1]);
        $a2->parts()->attach([$p2->id => ['quantity' => 1], $p3->id => ['quantity' => 1]]);

        // ASSEMBLIES
        $a3->assemblies()->attach([$a1->id => ['quantity' => 5], $a2->id => ['quantity' => 5]]);

        Product::create([
            'name' => 'Product 1',
            'description' => 'Product 1 description',
            'price' => 100,
            'cost_price' => 50,
            'number' => 'P1',
            'assembly_id' => $a3->id,
        ]);
    }
}
