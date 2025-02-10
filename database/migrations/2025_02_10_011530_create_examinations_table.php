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
        Schema::create('examinations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId('appointment_id'); //id appointment
            $table->foreignId('patient_id'); //id pasien
            $table->foreignId('user_id'); // id dokter dari user
            $table->dateTime('examination_date');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->integer('systolic');
            $table->integer('diastolic');
            $table->integer('heart_rate');
            $table->integer('respiration_rate');
            $table->decimal('body_temperature', 4, 2);
            $table->text('examination_results');
            $table->string('file_upload', 255)->nullable();
            $table->string("created_by", 150)->nullable();
            $table->string("updated_by", 150)->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('appointment_id');
            $table->index('patient_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
