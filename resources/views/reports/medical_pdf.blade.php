<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Report - {{ $report->ref_no }}</title>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 11px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
        .lab-name { font-size: 24px; font-weight: bold; color: #1e3a8a; margin: 0; }
        .lab-sub { font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        
        .report-title { text-align: center; font-size: 14px; font-weight: bold; text-decoration: underline; margin-bottom: 20px; text-transform: uppercase; }
        
        .patient-box { width: 100%; margin-bottom: 25px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: #fafafa; }
        .patient-table { width: 100%; border-collapse: collapse; }
        .patient-table td { padding: 4px 8px; vertical-align: top; }
        .label { font-weight: bold; color: #555; width: 15%; text-transform: uppercase; font-size: 9px; }
        .value { border-bottom: 1px border #eee; width: 35%; font-weight: bold; color: #000; }
        
        .test-section { margin-bottom: 20px; }
        .test-header { background: #f0f4f8; padding: 5px 10px; font-weight: bold; color: #1e3a8a; border-left: 4px solid #1e3a8a; margin-bottom: 10px; font-size: 12px; }
        
        .results-table { width: 100%; border-collapse: collapse; }
        .results-table th { background: #eee; padding: 5px 10px; text-align: left; font-size: 10px; border: 1px solid #ddd; }
        .results-table td { padding: 5px 10px; border-bottom: 1px solid #eee; text-align: left; border: 1px solid #ddd; }
        .res-label { width: 40%; font-weight: 500; }
        .res-value { width: 30%; font-weight: bold; text-align: center; }
        .res-unit { width: 30%; color: #666; font-style: italic; }
        
        .summary-box { margin-top: 30px; border: 1px solid #1e3a8a; padding: 15px; border-radius: 5px; }
        .status-fit { color: #15803d; font-size: 18px; font-weight: bold; }
        .status-unfit { color: #b91c1c; font-size: 18px; font-weight: bold; }
        
        .signature-area { margin-top: 50px; }
        .sig-block { float: right; width: 200px; text-align: center; }
        .sig-line { border-top: 1px solid #000; margin-top: 40px; padding-top: 5px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="lab-name">{{ $lab_name }}</h1>
        <div class="lab-sub">Premium Diagnostic & Research Center</div>
    </div>

    <div class="report-title">Medical Examination Report</div>

    <div class="patient-box">
        <table class="patient-table">
            <tr>
                <td class="label">Patient Name</td>
                <td class="value">{{ $report->patient_name }}</td>
                <td class="label">Ref No.</td>
                <td class="value">{{ $report->ref_no }}</td>
            </tr>
            <tr>
                <td class="label">Passport No.</td>
                <td class="value">{{ $report->passport_no ?: 'N/A' }}</td>
                <td class="label">Medical Date</td>
                <td class="value">{{ $report->medical_date->format('d-M-Y') }}</td>
            </tr>
            <tr>
                <td class="label">Blood Group</td>
                <td class="value">{{ $report->blood_group ?: 'N/A' }}</td>
                <td class="label">Party/Agent</td>
                <td class="value">{{ $report->client->name ?? 'Direct' }}</td>
            </tr>
        </table>
    </div>

    @foreach($report->testResults as $result)
        <div class="test-section">
            <div class="test-header">{{ $result->test->name }}</div>
            <table class="results-table">
                <thead>
                    <tr>
                        <th class="res-label">Examination Item</th>
                        <th class="res-value">Result</th>
                        <th class="res-unit">Reference Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $fields = json_decode($result->test->fields_json, true) ?? [];
                        $results_data = $result->data_json;
                    @endphp
                    @foreach($fields as $field)
                        <tr>
                            <td class="res-label">{{ $field['label'] }}</td>
                            <td class="res-value">{{ $results_data[$field['name']] ?? '---' }}</td>
                            <td class="res-unit">{{ $field['unit'] ?: '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="summary-box">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div style="font-weight: bold; margin-bottom: 5px;">CONCLUSION / FITNESS STATUS:</div>
                    @if(strtoupper($report->fitness_status) == 'FIT')
                        <div class="status-fit">SUITABLE / FIT</div>
                    @elseif(strtoupper($report->fitness_status) == 'UNFIT')
                        <div class="status-unfit">UNSUITABLE / UNFIT</div>
                    @else
                        <div style="font-size: 18px; font-weight: bold; color: #666;">{{ $report->fitness_status ?: 'PENDING' }}</div>
                    @endif
                </td>
                <td width="50%" style="border-left: 1px solid #ddd; padding-left: 20px;">
                    <div style="font-weight: bold; margin-bottom: 5px;">REMARKS / DOCTOR NOTES:</div>
                    <div style="font-style: italic;">{{ $report->remarks ?: 'No specific remarks noted during examination.' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="signature-area">
        <div class="sig-block">
            <div class="sig-line">Laboratory In-Charge</div>
            <div style="font-size: 8px; color: #999;">Electronically Generated Report</div>
        </div>
    </div>

</body>
</html>
