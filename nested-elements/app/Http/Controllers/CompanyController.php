<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:companies,domain',
        ]);

        $company = Company::create($request->only('name', 'domain'));

        // Create tenant and domain
        $tenant = Tenant::create([
            'id' => $company->name,
            'company_id' => $company->id,
        ]);

        Domain::create([
            'domain' => $company->domain,
            'tenant_id' => $tenant->id,
        ]);

        return redirect('/admin')->with('success', 'Company created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
