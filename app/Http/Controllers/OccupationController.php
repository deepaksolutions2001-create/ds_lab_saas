<?php

namespace App\Http\Controllers;

use App\Services\OccupationService;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    protected $occupationService;

    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occupations = $this->occupationService->getAll();
        return view('masters.occupations.index', compact('occupations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masters.occupations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $this->occupationService->create($data);

        return redirect()->route('occupations.index')->with('success', 'Occupation created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $occupation = \App\Models\Occupation::findOrFail($id);
        return view('masters.occupations.edit', compact('occupation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $this->occupationService->update($id, $data);

        return redirect()->route('occupations.index')->with('success', 'Occupation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->occupationService->delete($id);
        return redirect()->route('occupations.index')->with('success', 'Occupation deleted successfully.');
    }
}
