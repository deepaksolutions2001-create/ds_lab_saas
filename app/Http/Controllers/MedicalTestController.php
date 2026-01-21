<?php

namespace App\Http\Controllers;

use App\Models\MedicalTest;
use Illuminate\Http\Request;

class MedicalTestController extends Controller
{
    public function __construct()
    {
        // Handled via route middleware
    }

    public function index()
    {
        $tests = MedicalTest::orderBy('name')->get();
        return view('settings.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('settings.tests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'fields_json' => 'required|json',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['fields_json'] = json_decode($request->fields_json, true);
        MedicalTest::create($data);

        return redirect()->route('medical-tests.index')->with('success', 'Medical Test definition created.');
    }

    public function edit($id)
    {
        $test = MedicalTest::findOrFail($id);
        return view('settings.tests.edit', compact('test'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'fields_json' => 'required|json',
            'is_active' => 'boolean',
        ]);

        $test = MedicalTest::findOrFail($id);
        $data = $validated;
        $data['fields_json'] = json_decode($request->fields_json, true);
        $test->update($data);

        return redirect()->route('medical-tests.index')->with('success', 'Medical Test definition updated.');
    }

    public function destroy($id)
    {
        $test = MedicalTest::findOrFail($id);
        $test->delete();
        return redirect()->route('medical-tests.index')->with('success', 'Test definition deleted.');
    }
}
