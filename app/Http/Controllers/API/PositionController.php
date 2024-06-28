<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        return response()->json(Position::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $position = Position::create($validatedData);

        return response()->json($position, 201);
    }

    public function show(Position $position)
    {
        return response()->json($position, 200);
    }

    public function update(Request $request, Position $position)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $position->update($validatedData);

        return response()->json($position, 200);
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return response()->json(null, 204);
    }
}
