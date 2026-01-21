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
        // Product Categories
        Schema::create('inventory_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->index();
            $table->string('name');
            $table->timestamps();
        });

        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->index();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->string('name');
            $table->string('unit')->default('pcs'); // pcs, kg, litre
            $table->integer('quantity')->default(0);
            $table->integer('alert_level')->default(5);
            $table->timestamps();
        });

        // Inventory Logs
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('type'); // add, remove, adjust
            $table->integer('quantity');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Who did it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_tables');
    }
};
