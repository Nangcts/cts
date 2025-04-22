<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('status')->default(0);
            $table->integer('user_id')->default(1);
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_adress');
            $table->text('customer_message');
            $table->unsignedDecimal('amount', 15, 4);
            $table->timestamps();
        });
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transaction')->onDelete('CASCADE');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedSmallInteger('status');
            $table->unsignedDecimal('order_amount', 15, 4);
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
        Schema::dropIfExists('transaction');
    }
}
