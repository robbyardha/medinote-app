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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('patient_id');
            $table->string('queue_number', 50);
            $table->enum('status', ['Waiting', 'Called', 'Completed', 'Cancelled'])->default('Waiting');
            $table->unsignedBigInteger('user_id'); //id dokter dari user
            $table->dateTime('appointment_time');
            $table->text('description')->nullable();
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('patient_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
