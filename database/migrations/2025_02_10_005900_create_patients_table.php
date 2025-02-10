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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 255);
            $table->string("gender", 150);
            $table->string("place_of_birth", 150);
            $table->string("date_of_birth", 150);
            $table->text("address");
            $table->string("number_phone", 150);
            $table->string("email", 150)->nullable();
            $table->string("blood_type", 150)->nullable();
            $table->string("work", 150)->nullable();
            $table->string("marital_status", 150)->nullable();
            $table->dateTime("registration_date");
            $table->dateTime("status");
            $table->string("created_by", 150)->nullable();
            $table->string("updated_by", 150)->nullable();
            $table->timestamps();

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
