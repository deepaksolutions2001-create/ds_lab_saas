<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadMedicalReport($id)
    {
        // 1. Fetch Report with relationships
        $report = MedicalReport::with(['testResults.test'])->findOrFail($id);

        // 2. Prepare Data
        $data = [
            'report' => $report,
            'lab_name' => 'Demo Lab', // This should refer to Lab Settings later
        ];

        // 3. Load View and Generate PDF
        $pdf = Pdf::loadView('reports.medical_pdf', $data);

        // 4. Download (or stream)
        return $pdf->stream('medical-report-' . $report->ref_no . '.pdf');
    }
}
