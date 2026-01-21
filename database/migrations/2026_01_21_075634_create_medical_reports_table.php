<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->index(); // Multi-tenancy
            
            // Part A - Legacy Compatible Fields
            $table->string('ref_no')->nullable();
            $table->dateTime('medical_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('patient_name');
            $table->string('father_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('passport_no')->nullable()->index();
            $table->unsignedBigInteger('client_id')->nullable()->index(); // Party/Agent
            
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bp')->nullable();
            $table->string('blood_group')->nullable();
            
            // Status & Financials
            $table->string('test_status')->default('pending'); // pending, completed
            $table->string('fitness_status')->nullable(); // FIT, UNFIT
            $table->decimal('amount_required', 10, 2)->default(0);
            $table->decimal('amount_received', 10, 2)->default(0);
            
            $table->text('remarks')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_locked')->default(false); // If true, Part A is locked
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};
