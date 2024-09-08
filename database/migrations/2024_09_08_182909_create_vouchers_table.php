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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'voucher_number');
            $table->date(column: 'date');
            $table->string(column: 'delivery_to');
            $table->string(column: 'vehicle');
            $table->string(column: 'plate');
            $table->string(column: 'kilometer');
            $table->string(column: 'station_name');
            $table->decimal(column: 'total_amount', total: 20, places: 2);
            $table->enum(column: 'state', allowed: ['ACTIVE', 'CANCELLED'])->default(value: "ACTIVE");
            $table->unsignedBigInteger(column: 'user_id');
            $table->timestamps();

            $table->foreign(columns: 'user_id')->references(columns: 'id')->on(table: 'users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
