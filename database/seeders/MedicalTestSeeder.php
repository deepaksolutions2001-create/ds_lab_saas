<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalTest;

class MedicalTestSeeder extends Seeder
{
    public function run()
    {
        $labId = 1; // Default
        
        $tests = [
            [
                'name' => 'Physical Examination',
                'category' => 'General',
                'fields_json' => [
                    'height' => 'Height (cm)',
                    'weight' => 'Weight (kg)',
                    'bp' => 'Blood Pressure',
                    'vision' => 'Vision (L/R)',
                    'hearing' => 'Hearing'
                ]
            ],
            [
                'name' => 'Chest X-Ray',
                'category' => 'Radiology',
                'fields_json' => [
                    'findings' => 'Findings',
                    'impression' => 'Impression'
                ]
            ],
            [
                'name' => 'HIV Test',
                'category' => 'Serology',
                'fields_json' => [
                    'method' => 'Method Used',
                    'result' => 'Result (Reactive/Non-Reactive)'
                ]
            ],
            [
                'name' => 'Urine Analysis',
                'category' => 'Pathology',
                'fields_json' => [
                    'color' => 'Color',
                    'sugar' => 'Sugar',
                    'albumin' => 'Albumin',
                    'microscopy' => 'Microscopy'
                ]
            ]
        ];

        foreach ($tests as $test) {
            MedicalTest::create(array_merge($test, ['lab_id' => $labId, 'is_active' => true]));
        }
    }
}
