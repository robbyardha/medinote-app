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
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("menu_id");
            $table->string("name", 150);
            $table->text("url");
            $table->tinyInteger("order")->default(0);
            $table->tinyInteger("is_show")->default(1);
            $table->string("created_by", 150)->nullable();
            $table->string("updated_by", 150)->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};
