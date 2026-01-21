<?php

namespace App\Services;

use App\Models\Occupation;

class OccupationService extends BaseService
{
    /**
     * Get all occupations for the current lab.
     */
    public function getAll()
    {
        return Occupation::orderBy('name')->get();
    }

    /**
     * Create a new occupation.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {
            return Occupation::create($data);
        });
    }

    /**
     * Update an occupation.
     */
    public function update(int $id, array $data)
    {
        return $this->transaction(function () use ($id, $data) {
            $occupation = Occupation::findOrFail($id);
            $occupation->update($data);
            return $occupation;
        });
    }

    /**
     * Delete an occupation.
     */
    public function delete(int $id)
    {
        return $this->transaction(function () use ($id) {
            $occupation = Occupation::findOrFail($id);
            return $occupation->delete();
        });
    }
}
