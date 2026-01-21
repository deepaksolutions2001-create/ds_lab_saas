<?php

namespace App\Http\Controllers;

use App\Services\DoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = $this->doctorService->getAll();
        return view('masters.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masters.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('signature')) {
            $data['signature_path'] = $request->file('signature')->store('doctors/signatures', 'public');
        }

        if ($request->hasFile('stamp')) {
            $data['stamp_path'] = $request->file('stamp')->store('doctors/stamps', 'public');
        }

        $this->doctorService->create($data);

        return redirect()->route('doctors.index')->with('success', 'Doctor registered successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        return view('masters.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'signature' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $doctor = \App\Models\Doctor::findOrFail($id);

        if ($request->hasFile('signature')) {
            if ($doctor->signature_path) Storage::disk('public')->delete($doctor->signature_path);
            $data['signature_path'] = $request->file('signature')->store('doctors/signatures', 'public');
        }

        if ($request->hasFile('stamp')) {
            if ($doctor->stamp_path) Storage::disk('public')->delete($doctor->stamp_path);
            $data['stamp_path'] = $request->file('stamp')->store('doctors/stamps', 'public');
        }

        $this->doctorService->update($id, $data);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->doctorService->delete($id);
        return redirect()->route('doctors.index')->with('success', 'Doctor record removed.');
    }
}
