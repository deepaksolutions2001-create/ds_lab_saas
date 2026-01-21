<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, \App\Traits\TenantScoped;

    protected $fillable = [
        'lab_id',
        'category_id',
        'name',
        'unit',
        'quantity',
        'alert_level',
    ];

    public function category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id');
    }

    public function logs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }
}
