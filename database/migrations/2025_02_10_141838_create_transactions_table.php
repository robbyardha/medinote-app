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
            $table->unsignedBigInteger('examination_id');
            $table->decimal('total_invoice', 15, 0);
            $table->decimal('total_pay', 15, 0);
            $table->decimal('total_change', 15, 0);
            $table->dateTime('payment_date');
            $table->string('payment_by', 155);
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('examination_id');
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
