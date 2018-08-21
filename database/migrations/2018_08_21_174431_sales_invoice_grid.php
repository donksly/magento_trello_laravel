<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesInvoiceGrid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_grid', function (Blueprint $table){
            $table->increments('entity_id');
            $table->string('increment_id')->unsigned()->index();
            $table->string('state');
            $table->string('store_id')->default(0);
            $table->string('store_name');
            $table->string('order_id')->unsigned()->index();
            $table->string('order_increment_id')->unsigned()->index();
            $table->string('order_created_at')->unsigned()->index();
            $table->string('customer_name')->unsigned()->index();
            $table->string('customer_email')->unsigned()->index();
            $table->integer('customer_group_id');
            $table->string('payment_method');
            $table->string('store_currency_code');
            $table->string('order_currency_code');
            $table->string('base_currency_code');
            $table->string('global_currency_code');
            $table->string('billing_name')->unsigned()->index();
            $table->string('billing_address')->unsigned()->index();
            $table->string('shipping_address')->unsigned()->index();
            $table->string('shipping_information');
            $table->decimal('subtotal', 12,4);
            $table->decimal('shipping_and_handling', 12,4);
            $table->decimal('grand_total', 12,4);
            $table->decimal('base_grand_total', 12,4)->unsigned()->index();
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
        //
    }
}
