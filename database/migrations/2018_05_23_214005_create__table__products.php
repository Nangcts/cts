<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_kiot')->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('slug');
            $table->string('slug_base');

            $table->unsignedInteger('catalog_id')->unsigned();
            $table->foreign('catalog_id')->references('id')->on('catalog')->onDelete('CASCADE');

            $table->unsignedInteger('user_id')->default(1);
            $table->unsignedInteger('category_id_kiot')->nullable();
            $table->unsignedInteger('price');
            $table->string('unit');
            $table->unsignedInteger('masterProductId')->nullable();
            $table->unsignedInteger('masterUnitId')->nullable();
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
        Schema::dropIfExists('product');
    }
}
