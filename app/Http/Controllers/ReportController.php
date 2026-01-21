<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display the Reports Hub.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Show the Party Ledger Query Form.
     */
    public function ledger()
    {
        $clients = Client::orderBy('name')->get();
        return view('reports.ledger.index', compact('clients'));
    }

    /**
     * Generate the Party Ledger.
     */
    public function generateLedger(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $this->reportService->getPartyLedger(
            $request->client_id,
            $request->start_date,
            $request->end_date
        );

        // If 'action' is 'pdf', we would generate a PDF here.
        // For now, we return the view.
        return view('reports.ledger.show', $data);
    }

    /**
     * Show the Party Balance Summary Hub.
     */
    public function balanceSummary()
    {
        $balances = $this->reportService->getPartyBalances();
        $totalReceivable = $balances->where('balance', '>', 0)->sum('balance');
        
        return view('reports.balances.index', compact('balances', 'totalReceivable'));
    }
}
