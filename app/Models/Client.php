<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantScoped;

class Client extends Model
{
    use HasFactory, TenantScoped;

    protected $fillable = [
        'lab_id',
        'name',
        'mobile',
        'email',
        'address',
        'opening_balance',
    ];

    public function reports()
    {
        return $this->hasMany(MedicalReport::class);
    }
}
