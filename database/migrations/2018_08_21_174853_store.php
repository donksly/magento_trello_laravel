<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Store extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table){
            $table->increments('store_id');
            $table->string('code');
            $table->tinyInteger('website_id')->default(0);
            $table->tinyInteger('group_id')->default(0);
            $table->string('name');
            $table->tinyInteger('sort_order')->default(0);
            $table->tinyInteger('is_active')->default(0);
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
