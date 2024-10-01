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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string(column: "station_name", length: 255);
            $table->string(column: "station_name_en", length: 255);
            $table->string(column: "city", length: 255);
            $table->date(column: "start_date");
            $table->date(column: "end_date");
            $table->unsignedInteger(column: "quantity");
            $table->decimal(column: "unit_price", total: 20, places: 2);
            $table->decimal(column: "total_amount", total: 20, places: 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
