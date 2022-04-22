<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cat', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->integer('id_list')->default(0);
            $table->string('type', 50)->nullable();
            $table->integer('is_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_cat');
    }
}