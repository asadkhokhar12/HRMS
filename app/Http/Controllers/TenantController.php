<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|unique:tenants',
            'domain' => 'required|unique:tenant_domains,domain',
        ]);

        $tenant = Tenant::create(['id' => $data['id']]);
        $tenant->domains()->create(['domain' => $data['domain']]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully');
    }

    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $data = $request->validate([
            'id' => 'required|unique:tenants,id,' . $tenant->id,
            'domain' => 'required|unique:tenant_domains,domain,' . $tenant->id . ',tenant_id',
        ]);

        $tenant->update(['id' => $data['id']]);
        $tenant->domains()->update(['domain' => $data['domain']]);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->domains()->delete();
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully');
    }
}
