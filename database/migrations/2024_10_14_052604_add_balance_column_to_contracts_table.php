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
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedInteger(column: 'balance')->default(0)->after(column: 'quantity');
            $table->string(column: 'fuel_type')->after(column: 'contract_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(columns: 'balance');
            $table->dropColumn(columns: 'fuel_type');
        });
    }
};
