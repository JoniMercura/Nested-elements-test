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
        $company1 = Company::create([
            'name' => 'Mercura',
            'domain' => 'mercura.dk',
        ]);
        
        // Create tenant for that company
        $tenant1 = Tenant::create([
            'id' => 'MercuraTenant',
            'company_id' => $company1->id,
            'azure_client_id' => '77990dae-003c-4e0c-996a-bb2895f84fe2',
            'azure_client_secret' => 'go_8Q~OUU24Ck45b~.nWgMmH_NxmHT6OtIxXhb.O',
            'azure_redirect_uri' => 'http://localhost/auth/microsoft/callback',
            'azure_tenant_id' => '85738de1-05c7-41dd-bbc1-c636f7d313b9',
        ]);

        // Create domain
        $tenant1->domains()->create(['domain' => 'mercura.localhost']);

        // Test company
        $company2 = Company::create([
            'name' => 'CompanyTest',
            'domain' => 'jonischimanskygmail.onmicrosoft.com',
        ]);

        $tenant2 = Tenant::create([
            'id' => 'tenant2',
            'company_id' => $company2->id,
            'azure_client_id' => 'ac69c8e4-d8f4-46eb-a679-c66296d37554',
            'azure_client_secret' => 'tf48Q~4qUwqeiHuv62ITmtgjK5VN1h4xRaclCbA~',
            'azure_redirect_uri' => 'http://localhost/auth/microsoft/callback',
            'azure_tenant_id' => 'c7bf80c1-b827-4a8d-b129-ad70da49ae24',
        ]);

        $tenant2->domains()->create(['domain' => 'companyTest.localhost']);

    }
}
