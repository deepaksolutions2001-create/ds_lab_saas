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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->index();
            $table->unsignedBigInteger('financial_year_id')->index();
            $table->unsignedBigInteger('client_id')->nullable()->index(); // For Parties/Agents
            
            $table->string('type'); // opening, medical, cash_received, amount_given, adjustment
            $table->string('description')->nullable();
            
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0); // Snapshot for performance
            
            $table->unsignedBigInteger('medical_report_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable(); // Creator
            
            $table->timestamps();
            
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
