<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuoteAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_address', function (Blueprint $table){
            $table->increments('address_id');
            $table->integer('quote_id')->unsigned()->index();
            $table->integer('customer_id');
            $table->tinyInteger('save_in_address_book')->default(0);
            $table->integer('customer_address_id');
            $table->string('address_type');
            $table->string('email');
            $table->string('prefix');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('suffix');
            $table->string('company');
            $table->string('street');
            $table->string('city');
            $table->string('region');
            $table->integer('region_id');
            $table->string('postcode');
            $table->string('country_id');
            $table->string('telephone');
            $table->string('fax');
            $table->tinyInteger('same_as_billing')->default(0);
            $table->tinyInteger('collect_shipping_rates')->default(0);
            $table->string('shipping_method');
            $table->string('shipping_description');
            $table->decimal('weight', 12,4);
            $table->decimal('subtotal', 12,4);
            $table->decimal('base_subtotal', 12,4);
            $table->decimal('subtotal_with_discount', 12,4);
            $table->decimal('base_subtotal_with_discount', 12,4);
            $table->decimal('tax_amount', 12,4);
            $table->decimal('base_tax_amount', 12,4);
            $table->decimal('shipping_amount', 12,4);
            $table->decimal('base_shipping_amount', 12,4);
            $table->decimal('shipping_tax_amount', 12,4);
            $table->decimal('base_shipping_tax_amount', 12,4);
            $table->decimal('discount_amount', 12,4);
            $table->decimal('base_discount_amount', 12,4);
            $table->decimal('grand_total', 12,4);
            $table->decimal('base_grand_total', 12,4);
            $table->string('customer_notes');
            $table->string('applied_taxes');
            $table->string('discount_description');
            $table->decimal('shipping_discount_amount', 12,4);
            $table->decimal('base_shipping_discount_amount', 12,4);
            $table->decimal('subtotal_incl_tax', 12,4);
            $table->decimal('base_subtotal_total_incl_tax', 12,4);
            $table->decimal('discount_tax_compensation_amount', 12,4);
            $table->decimal('base_discount_tax_compensation_amount', 12,4);
            $table->decimal('shipping_discount_tax_compensation_amount', 12,4);
            $table->decimal('base_shipping_discount_tax_compensation_amnt', 12,4);
            $table->decimal('shipping_incl_tax', 12,4);
            $table->decimal('base_shipping_incl_tax', 12,4);
            $table->tinyInteger('free_shipping')->default(0);
            $table->string('vat_id');
            $table->tinyInteger('vat_is_valid')->default(0);
            $table->string('vat_request_id');
            $table->string('vat_request_date');
            $table->tinyInteger('vat_request_success')->default(0);
            $table->integer('gift_message_id');
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
