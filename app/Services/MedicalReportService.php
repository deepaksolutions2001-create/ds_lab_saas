<?php

namespace App\Services;

use App\Models\MedicalReport;
use App\Models\MedicalTest;
use App\Models\MedicalTestResult;
use Exception;

class MedicalReportService extends BaseService
{
    protected $ledgerService;

    public function __construct(LedgerService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    /**
     * Create a new medical report with dynamic test results.
     */
    public function createReport(array $data, array $tests, int $labId, int $fyId)
    {
        return $this->transaction(function () use ($data, $tests, $labId, $fyId) {
            // 1. Create Part A (Fixed Data)
            $data['lab_id'] = $labId;
            $data['financial_year_id'] = $fyId;
            $report = MedicalReport::create($data);

            // 2. Process Part B (Dynamic Test Data)
            foreach ($tests as $testData) {
                MedicalTestResult::create([
                    'medical_report_id' => $report->id,
                    'medical_test_id' => $testData['test_id'],
                    'data_json' => $testData['results'],
                ]);
            }

            // 3. Ledger Entry Logic
            if (!empty($report->client_id)) {
                $this->chargeToLedger($report, $labId, $fyId);
            }

            return $report;
        });
    }

    /**
     * Internal helper to handle ledger entries for reports.
     */
    protected function chargeToLedger(MedicalReport $report, int $labId, int $fyId)
    {
        // Record Debit (Amount Charged to Agent)
        if ($report->amount_required > 0) {
            $this->ledgerService->createEntry([
                'lab_id' => $labId,
                'financial_year_id' => $fyId,
                'client_id' => $report->client_id,
                'type' => 'DR',
                'amount' => $report->amount_required,
                'description' => "Medical Report #{$report->id} ({$report->patient_name}) - Lab Fee Charged",
                'medical_report_id' => $report->id,
            ]);
        }

        // Record Credit (Total Patient Payment)
        if ($report->amount_received > 0) {
            $this->ledgerService->createEntry([
                'lab_id' => $labId,
                'financial_year_id' => $fyId,
                'client_id' => $report->client_id,
                'type' => 'CR',
                'amount' => $report->amount_received,
                'description' => "Medical Report #{$report->id} ({$report->patient_name}) - Total Payment Received",
                'medical_report_id' => $report->id,
            ]);
        }
    }

    /**
     * Update an existing medical report.
     */
    public function updateReport(int $reportId, array $data, array $tests)
    {
        return $this->transaction(function () use ($reportId, $data, $tests) {
            $report = MedicalReport::findOrFail($reportId);
            
            if ($report->is_locked) {
                throw new Exception("This medical report is locked and cannot be edited.");
            }

            $report->update($data);

            foreach ($tests as $testData) {
                MedicalTestResult::updateOrCreate(
                    [
                        'medical_report_id' => $report->id,
                        'medical_test_id' => $testData['test_id'],
                    ],
                    [
                        'data_json' => $testData['results']
                    ]
                );
            }

            return $report;
        });
    }
}
