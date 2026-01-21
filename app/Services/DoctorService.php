<?php

namespace App\Services;

use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;

class DoctorService extends BaseService
{
    /**
     * Get all doctors for the current lab.
     */
    public function getAll()
    {
        return Doctor::orderBy('name')->get();
    }

    /**
     * Create a new doctor with optional signature and stamp.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {
            return Doctor::create($data);
        });
    }

    /**
     * Update an existing doctor and handle file replacements.
     */
    public function update(int $id, array $data)
    {
        return $this->transaction(function () use ($id, $data) {
            $doctor = Doctor::findOrFail($id);
            
            // Note: File deletion logic for old signature/stamp would go here if needed
            // But usually we just overwrite or keep them.
            
            $doctor->update($data);
            return $doctor;
        });
    }

    /**
     * Delete a doctor.
     */
    public function delete(int $id)
    {
        return $this->transaction(function () use ($id) {
            $doctor = Doctor::findOrFail($id);
            
            // Delete associated files if they exist
            if ($doctor->signature_path) Storage::delete($doctor->signature_path);
            if ($doctor->stamp_path) Storage::delete($doctor->stamp_path);
            
            return $doctor->delete();
        });
    }
}
