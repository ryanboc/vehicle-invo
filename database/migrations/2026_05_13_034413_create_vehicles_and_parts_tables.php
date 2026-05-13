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
       Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('vin')->unique()->nullable();
        $table->string('make');
        $table->string('model');
        $table->integer('year');
        $table->string('engine')->nullable();
        $table->timestamps();
    });

    Schema::create('parts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        $table->string('name');         // e.g., Oil Filter
        $table->string('part_number');  // e.g., 90915-YZZN1
        $table->integer('quantity')->default(0);
        $table->decimal('price', 8, 2)->default(0.00);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
        Schema::dropIfExists('vehicles');
    }
};
