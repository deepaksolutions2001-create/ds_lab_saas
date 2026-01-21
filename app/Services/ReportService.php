<?php

namespace App\Services;

use App\Models\Ledger;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService extends BaseService
{
    /**
     * Generate a Party Ledger Statement.
     * 
     * @param int $clientId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getPartyLedger($clientId, $startDate, $endDate)
    {
        // 1. Fetch Client Basic Info
        $client = Client::findOrFail($clientId);
        
        // 2. Calculate Opening Balance as of Start Date
        // Formula: Client Initial Opening + (Total Dr - Total Cr) before Start Date
        $initialBalance = $client->opening_balance ?? 0;
        
        $prePeriodDr = Ledger::where('client_id', $clientId)
            ->whereDate('created_at', '<', $startDate)
            ->where('type', 'DR')
            ->sum('amount');

        $prePeriodCr = Ledger::where('client_id', $clientId)
            ->whereDate('created_at', '<', $startDate)
            ->where('type', 'CR')
            ->sum('amount');
            
        $openingBalance = $initialBalance + $prePeriodDr - $prePeriodCr;

        // 3. Fetch Transactions within Date Range
        $transactions = Ledger::with('medicalReport')
            ->where('client_id', $clientId)
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        // 4. Calculate Running Balance for each transaction
        $runningBalance = $openingBalance;
        $formattedTransactions = $transactions->map(function ($entry) use (&$runningBalance) {
            if ($entry->type === 'DR') {
                $runningBalance += $entry->amount;
            } else {
                $runningBalance -= $entry->amount;
            }
            
            $entry->running_balance = $runningBalance;
            return $entry;
        });

        // 5. Summary Totals
        $periodDebits = $formattedTransactions->where('type', 'DR')->sum('amount');
        $periodCredits = $formattedTransactions->where('type', 'CR')->sum('amount');
        $closingBalance = $openingBalance + $periodDebits - $periodCredits;

        return [
            'client' => $client,
            'opening_balance' => $openingBalance,
            'transactions' => $formattedTransactions,
            'period_debits' => $periodDebits,
            'period_credits' => $periodCredits,
            'closing_balance' => $closingBalance,
            'date_range' => [
                'start' => Carbon::parse($startDate)->format('d-M-Y'),
                'end' => Carbon::parse($endDate)->format('d-M-Y'),
            ]
        ];
    }

    /**
     * Get live balance summary for all clients.
     * 
     * @return array
     */
    public function getPartyBalances()
    {
        $clients = Client::orderBy('name')->get();
        
        return $clients->map(function ($client) {
            $totalDr = Ledger::where('client_id', $client->id)->where('type', 'DR')->sum('amount');
            $totalCr = Ledger::where('client_id', $client->id)->where('type', 'CR')->sum('amount');
            
            $liveBalance = ($client->opening_balance ?? 0) + $totalDr - $totalCr;
            
            return [
                'id' => $client->id,
                'name' => $client->name,
                'mobile' => $client->mobile,
                'balance' => $liveBalance,
                'last_activity' => Ledger::where('client_id', $client->id)->latest()->value('created_at')
            ];
        });
    }
}
