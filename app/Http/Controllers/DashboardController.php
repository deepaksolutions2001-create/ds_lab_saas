<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalReport;
use App\Models\Client;
use App\Models\Product;
use App\Models\Doctor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vital Stats
        $today = Carbon::today();
        
        $stats = [
            'today_reports' => MedicalReport::whereDate('created_at', $today)->count(),
            'total_reports' => MedicalReport::count(),
            'pending_reports' => MedicalReport::where('test_status', 'pending')->count(),
            'today_revenue' => MedicalReport::whereDate('created_at', $today)->sum('amount_received'),
        ];

        // Recent Activity
        $recent_reports = MedicalReport::with('client')->latest()->take(5)->get();
        
        // Inventory Alerts
        $low_stock = Product::whereColumn('stock', '<=', 'alert_level')->count();
        
        // Active Registry
        $active_doctors = Doctor::where('is_active', true)->count();
        $active_clients = Client::count();

        return view('dashboard.index', compact('stats', 'recent_reports', 'low_stock', 'active_doctors', 'active_clients'));
    }
}
