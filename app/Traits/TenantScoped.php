<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait TenantScoped
{
    /**
     * Boot the trait.
     */
    public static function bootTenantScoped()
    {
        // 1. Automatically assign lab_id and financial_year_id when creating models
        static::creating(function ($model) {
            $labId = session('lab_id');
            
            // Absolute recovery: check session first, then user record
            if (!$labId && session()->has('user_id')) {
                $user = \App\Models\User::find(session('user_id'));
                if ($user && $user->lab_id) {
                    $labId = $user->lab_id;
                    session(['lab_id' => $labId]);
                }
            }

            if ($labId) {
                $model->lab_id = $model->lab_id ?? $labId;
                
                // Ensure financial year also recovers
                if (!session()->has('financial_year_id')) {
                    $fy = \App\Models\FinancialYear::where('lab_id', $labId)->where('is_active', true)->first();
                    if ($fy) session(['financial_year_id' => $fy->id]);
                }
            }

            if (session()->has('financial_year_id')) {
                $model->financial_year_id = $model->financial_year_id ?? session('financial_year_id');
            }
        });

        // 2. Automatically filter all queries
        static::addGlobalScope('tenant_isolation', function (Builder $builder) {
            $table = $builder->getModel()->getTable();
            $labId = session('lab_id');

            // Lab Isolation
            if ($labId) {
                $builder->where($table . '.lab_id', $labId);
            }

            // Financial Year Isolation
            if (session()->has('financial_year_id') && Schema::hasColumn($table, 'financial_year_id')) {
                $builder->where($table . '.financial_year_id', session('financial_year_id'));
            }

            // Client Isolation: If user is a client, they only see their OWN data (if table has client_id)
            if (session()->has('client_id') && session('client_id') && Schema::hasColumn($table, 'client_id')) {
                $builder->where($table . '.client_id', session('client_id'));
            }
        });
    }

    /**
     * Define the lab relationship.
     */
    public function lab()
    {
        return $this->belongsTo(\App\Models\Lab::class);
    }
}
