<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "module_orders";

    protected $fillable = ['sales_order_id','supplier_id','state'];
}
