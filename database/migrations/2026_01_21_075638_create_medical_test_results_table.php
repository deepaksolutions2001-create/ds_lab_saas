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
        Schema::create('medical_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_report_id')->index(); // Links to Part A
            $table->unsignedBigInteger('medical_test_id')->index();   // Links to Definition
            $table->json('data_json'); // Stores the actual values (Part B data)
            $table->timestamps();
            
            $table->foreign('medical_report_id')->references('id')->on('medical_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_test_results');
    }
};
