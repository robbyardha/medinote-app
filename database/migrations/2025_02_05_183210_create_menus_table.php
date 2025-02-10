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
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->text("icon")->nullable();
            $table->string("name", 150);
            $table->text("url");
            $table->string("category", 150)->nullable();
            $table->tinyInteger("order")->default(0);
            $table->tinyInteger("is_show")->default(1);
            $table->tinyInteger("is_single")->default(0);
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
        Schema::dropIfExists('menus');
    }
};
