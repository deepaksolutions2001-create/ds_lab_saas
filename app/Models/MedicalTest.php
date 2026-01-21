<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTest extends Model
{
    use HasFactory, \App\Traits\TenantScoped;

    protected $fillable = [
        'lab_id',
        'name',
        'category',
        'fields_json',
        'is_active',
    ];

    protected $casts = [
        'fields_json' => 'array',
        'is_active' => 'boolean',
    ];

    public function results()
    {
        return $this->hasMany(MedicalTestResult::class);
    }
}
