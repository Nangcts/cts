<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDonThuoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_thuoc', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->smallInteger('status');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('customer_adress');
            $table->string('file_name');
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
        Schema::dropIfExists('don_thuoc');
    }
}
