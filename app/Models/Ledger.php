<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory, \App\Traits\TenantScoped;

    protected $fillable = [
        'lab_id',
        'financial_year_id',
        'client_id',
        'type',
        'description',
        'amount',
        'balance',
        'medical_report_id',
        'user_id',
    ];

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function medicalReport()
    {
        return $this->belongsTo(MedicalReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
