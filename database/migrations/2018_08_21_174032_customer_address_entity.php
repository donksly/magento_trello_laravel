<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerAddressEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address_entity', function (Blueprint $table){
            $table->increments('entity_id');
            $table->string('increment_id');
            $table->integer('parent_id')->unsigned()->index();
            $table->tinyInteger('is_active')->default(0);
            $table->string('city');
            $table->string('company');
            $table->string('country_id');
            $table->string('fax');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('postcode');
            $table->string('prefix');
            $table->string('region');
            $table->integer('region_id');
            $table->string('street');
            $table->string('suffix');
            $table->string('telephone');
            $table->string('vat_id');
            $table->integer('vat_is_valid');
            $table->string('vat_request_date');
            $table->string('vat_request_id');
            $table->integer('vat_request_success');
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
