<?php

namespace App\Services;

use App\Models\Client;

class ClientService extends BaseService
{
    /**
     * Get all clients for the current lab.
     */
    public function getAll()
    {
        return Client::orderBy('name')->get();
    }

    /**
     * Create a new client.
     */
    public function create(array $data)
    {
        return $this->transaction(function () use ($data) {
            $labId = session('lab_id');
            
            // Final fallback: If session is still missing, try to get from first lab if admin
            if (!$labId) {
                $labId = \App\Models\Lab::value('id');
            }

            if (!$labId) {
                throw new \Exception("Lab context not found. Please log in again.");
            }

            // Use explicit instantiation to bypass any mass-assignment or trait-boot timing issues
            $client = new Client();
            $client->name = $data['name'];
            $client->mobile = $data['mobile'] ?? null;
            $client->email = $data['email'] ?? null;
            $client->address = $data['address'] ?? null;
            $client->opening_balance = $data['opening_balance'] ?? 0;
            $client->lab_id = $labId;
            
            // Ensure session is synchronized
            session(['lab_id' => $labId]);
            
            $client->save();
            return $client;
        });
    }

    /**
     * Update an existing client.
     */
    public function update(int $id, array $data)
    {
        return $this->transaction(function () use ($id, $data) {
            $client = Client::findOrFail($id);
            $client->update($data);
            return $client;
        });
    }

    /**
     * Delete a client.
     */
    public function delete(int $id)
    {
        return $this->transaction(function () use ($id) {
            $client = Client::findOrFail($id);
            return $client->delete();
        });
    }
}
