<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned()->index();
            $table->integer('supplier_id')->unsigned()->index();
            $table->tinyInteger('previous_state')->default(0);
            $table->tinyInteger('next_state')->default(0);
            $table->tinyInteger('closed_check')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('viewed')->default(0);
            $table->string('error_log', 50);
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
        Schema::dropIfExists('orders');
    }
}
