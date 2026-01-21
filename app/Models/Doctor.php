<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantScoped;

class Doctor extends Model
{
    use HasFactory, TenantScoped;

    protected $fillable = [
        'lab_id',
        'name',
        'specialization',
        'signature_path',
        'stamp_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
