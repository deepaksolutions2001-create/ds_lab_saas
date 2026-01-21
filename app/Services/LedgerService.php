<?php

namespace App\Services;

use App\Models\Ledger;
use App\Models\FinancialYear;
use Exception;

class LedgerService extends BaseService
{
    /**
     * Create a ledger entry and update running balance.
     */
    public function createEntry(array $data)
    {
        return $this->transaction(function () use ($data) {
            $labId = $data['lab_id'];
            $clientId = $data['client_id'];
            
            // 1. Get Active Financial Year (Use provided fyId or session)
            $fyId = $data['financial_year_id'] ?? session('financial_year_id');
            
            if (!$fyId) {
                $fy = FinancialYear::where('lab_id', $labId)
                    ->where('is_active', true)
                    ->where('is_closed', false)
                    ->first();
                
                if (!$fy) {
                    throw new Exception("No active financial year found.");
                }
                $fyId = $fy->id;
            }

            // 2. Get Last Balance for this client
            $lastEntry = Ledger::where('lab_id', $labId)
                ->where('client_id', $clientId)
                ->orderBy('id', 'desc')
                ->first();
            
            $previousBalance = $lastEntry ? $lastEntry->balance : 0;
            
            // 3. Calculate New Balance
            $amount = $data['amount'];
            $type = $data['type']; // 'DR' or 'CR'
            
            if ($type === 'DR') {
                $newBalance = $previousBalance + $amount;
            } else {
                $newBalance = $previousBalance - $amount;
            }

            // 4. Save Entry
            return Ledger::create([
                'lab_id' => $labId,
                'financial_year_id' => $fyId,
                'client_id' => $clientId,
                'type' => $type,
                'description' => $data['description'],
                'amount' => $amount,
                'balance' => $newBalance,
                'medical_report_id' => $data['medical_report_id'] ?? null,
                'user_id' => session('user_id'),
            ]);
        });
    }
}
