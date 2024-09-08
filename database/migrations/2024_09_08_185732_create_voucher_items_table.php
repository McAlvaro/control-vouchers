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
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'voucher_id');
            $table->decimal(column: 'quantity', total: 20, places: 2);
            $table->text(column: 'description');
            $table->decimal(column: 'unit_price', total: 20, places: 2);
            $table->decimal(column: 'total_price', total: 20, places: 2);
            $table->timestamps();

            $table->foreign(columns: 'voucher_id')->references(columns: 'id')->on(table: 'vouchers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_items');
    }
};
