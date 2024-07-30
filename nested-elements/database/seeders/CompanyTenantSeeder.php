<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Domain;
use App\Models\Tenant;

class CompanyTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create company
        $company = Company::create([
            'name' => 'Mercura',
            'domain' => 'mercura.dk',
        ]);
        
        // Create tenant for that company
        $tenant = Tenant::create([
            'id' => 'MercuraTenant',
            'company_id' => $company->id,
            'data' => json_encode(['company_id' => $company->id]),
        ]);

        // Create domain
        $tenant->domains()->create([
            'domain' => 'mercura.localhost',
        ]);

    }
}
