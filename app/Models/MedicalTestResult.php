<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_report_id',
        'medical_test_id',
        'data_json',
    ];

    protected $casts = [
        'data_json' => 'array',
    ];

    public function report()
    {
        return $this->belongsTo(MedicalReport::class, 'medical_report_id');
    }

    public function test()
    {
        return $this->belongsTo(MedicalTest::class, 'medical_test_id');
    }
}
