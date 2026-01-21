<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory, \App\Traits\TenantScoped;

    protected $fillable = [
        'lab_id',
        'ref_no',
        'medical_date',
        'patient_name',
        'father_name',
        'gender',
        'dob',
        'passport_no',
        'client_id',
        'height',
        'weight',
        'bp',
        'blood_group',
        'occupation_id',
        'test_status',
        'fitness_status',
        'amount_required',
        'amount_received',
        'remarks',
        'photo',
        'is_locked',
    ];

    protected $casts = [
        'medical_date' => 'datetime',
        'dob' => 'date',
        'is_locked' => 'boolean',
    ];

    public function testResults()
    {
        return $this->hasMany(MedicalTestResult::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->ref_no) {
                $count = static::whereYear('created_at', now()->year)->count() + 1;
                $model->ref_no = 'MR-' . now()->format('ym') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
