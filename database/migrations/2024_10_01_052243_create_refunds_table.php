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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: "voucher_id");
            $table->date(column: "date");
            $table->string(column: "invoice_number", length: 255);
            $table->unsignedInteger(column: "quantity");
            $table->timestamps();

            $table->foreign(columns: "voucher_id")->references("id")->on("vouchers");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
