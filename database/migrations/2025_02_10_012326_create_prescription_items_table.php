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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->string('medicine_id');
            $table->string('medicine_name');
            $table->integer('unit_price'); //harga obat
            $table->integer('qty'); //qty obat
            $table->string('dose'); // dosis
            $table->string("created_by", 150)->nullable();
            $table->string("updated_by", 150)->nullable();
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');

            $table->index('id');
            $table->index('prescription_id');
            $table->index('medicine_id', 'medicine_id_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
