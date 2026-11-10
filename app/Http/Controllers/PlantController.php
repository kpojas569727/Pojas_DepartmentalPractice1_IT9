<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    // Shared validation rules for add and edit
    private function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:' . implode(',', Plant::CATEGORIES),
            // Server-side check: must be a number and not negative
            'unit_price'   => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'stock_status' => 'required|in:in_stock,out_of_stock',
        ];
    }

    public function index()
    {
        // with('user') loads the creator in one query (avoids N+1)
        $plants = Plant::with('user')->latest()->paginate(10);
        return view('plants.index', compact('plants'));
    }

    public function create()
    {
        return view('plants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // Business logic: record which logged-in user created this plant
        $data['user_id'] = auth()->id();

        Plant::create($data);

        return redirect()->route('plants.index')->with('success', 'Plant added successfully.');
    }

    public function show(Plant $plant)
    {
        return view('plants.show', compact('plant'));
    }

    public function edit(Plant $plant)
    {
        return view('plants.edit', compact('plant'));
    }

    public function update(Request $request, Plant $plant)
    {
        $data = $request->validate($this->rules());

        // user_id is not changed on update: the original creator stays
        $plant->update($data);

        return redirect()->route('plants.index')->with('success', 'Plant updated successfully.');
    }

    public function destroy(Plant $plant)
    {
        $plant->delete();

        return redirect()->route('plants.index')->with('success', 'Plant deleted.');
    }
}