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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('appointment_id');
            $table->string('total_invoice', 200);
            $table->string('total_pay', 200);
            $table->dateTime('payment_date');
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('appointment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
