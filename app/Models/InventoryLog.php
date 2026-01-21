<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory, \App\Traits\TenantScoped;

    protected $fillable = [
        'lab_id',
        'product_id',
        'type',
        'quantity',
        'reason',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
