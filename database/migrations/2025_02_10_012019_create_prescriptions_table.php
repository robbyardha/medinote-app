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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('examination_id')->constrained('examinations')->onDelete('cascade');
            $table->enum('status', ['process', 'not_taken', 'taken'])->default('not_taken');
            $table->string("created_by", 150)->nullable();
            $table->string("updated_by", 150)->nullable();
            $table->timestamps();

            $table->foreign('examination_id')->references('id')->on('examinations')->onDelete('cascade');

            $table->index('id');
            $table->index('examination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
