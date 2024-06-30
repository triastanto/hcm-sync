<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        return response()->json(Organization::paginate(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organizations,id',
        ]);

        $organization = Organization::create($validatedData);

        return response()->json($organization, 201);
    }

    public function show(Organization $organization)
    {
        return response()->json($organization, 200);
    }

    public function update(Request $request, Organization $organization)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organizations,id',
        ]);

        $organization->update($validatedData);

        return response()->json($organization, 200);
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return response()->json(null, 204);
    }
}
