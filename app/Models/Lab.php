<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'contact_no',
        'address',
        'logo',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Add more as needed
}
