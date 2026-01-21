<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\MedicalTest;
use Illuminate\Http\Request;
use App\Services\MedicalReportService;
use Exception;

class MedicalReportController extends Controller
{
    protected $medicalService;

    //here
    public function __construct(MedicalReportService $medicalService)
    {
        $this->medicalService = $medicalService;
    }

    public function index()
    {
        $reports = MedicalReport::orderBy('id', 'desc')->paginate(10);
        return view('medical.index', compact('reports'));
    }

    public function create()
    {
        $tests = \App\Models\MedicalTest::where('is_active', true)->get();
        $clients = \App\Models\Client::all();
        $occupations = \App\Models\Occupation::where('is_active', true)->get();
        return view('medical.create', compact('tests', 'clients', 'occupations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'passport_no' => 'nullable|string|max:32',
            'medical_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'occupation_id' => 'nullable|exists:occupations,id',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|string|max:10',
            'weight' => 'nullable|string|max:10',
            'bp' => 'nullable|string|max:20',
            'fitness_status' => 'nullable|string',
            'amount_required' => 'nullable|numeric',
            'amount_received' => 'nullable|numeric',
        ]);

        try {
            // Prepare Part B Data (Tests)
            $tests = [];
            if ($request->has('test_results')) {
                foreach ($request->input('test_results') as $testId => $results) {
                    $tests[] = [
                        'test_id' => $testId,
                        'results' => $results
                    ];
                }
            }

            // Prepare Part A Data
            $data = $request->except(['test_results', '_token']);
            if (empty($data['ref_no'])) {
                $data['ref_no'] = 'REF-' . time() . '-' . rand(10, 99);
            }

            // lab_id is automatically handled by the Service or the Trait if we use mass assignment
            // But let's pass it explicitly for clarity in the service layer
            $labId = session('lab_id');
            $fyId = session('financial_year_id');

            $this->medicalService->createReport($data, $tests, $labId, $fyId);

            return redirect()->route('medical.index')->with('success', 'Medical Report created successfully.');

        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $report = MedicalReport::with('testResults.test')->findOrFail($id);
        return view('medical.show', compact('report'));
    }

    public function edit($id)
    {
        $report = MedicalReport::with('testResults.test')->findOrFail($id);
        $tests = MedicalTest::where('is_active', true)->get();
        $clients = \App\Models\Client::all();
        $occupations = \App\Models\Occupation::where('is_active', true)->get();
        
        return view('medical.edit', compact('report', 'tests', 'clients', 'occupations'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'passport_no' => 'nullable|string|max:32',
            'medical_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'occupation_id' => 'nullable|exists:occupations,id',
            'blood_group' => 'nullable|string',
            'height' => 'nullable|string|max:10',
            'weight' => 'nullable|string|max:10',
            'bp' => 'nullable|string|max:20',
            'fitness_status' => 'nullable|string',
            'amount_required' => 'nullable|numeric',
            'amount_received' => 'nullable|numeric',
        ]);

        try {
            $testResults = [];
            if ($request->has('test_results')) {
                foreach ($request->input('test_results') as $testId => $results) {
                    $testResults[] = [
                        'test_id' => $testId,
                        'results' => $results
                    ];
                }
            }

            $data = $request->except(['test_results', '_token', '_method']);
            
            $this->medicalService->updateReport($id, $data, $testResults);

            return redirect()->route('medical.index')->with('success', 'Medical Report updated successfully.');

        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
