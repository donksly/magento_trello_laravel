<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "module_orders";
    protected $guarded = [];

    public function ordersSupplierRelationship()
    {
        return $this->belongsTo(Suppliers::class,'supplier_id','id');
    }

    public function fetchMagentoOrders()
    {
        return $this->belongsTo(MagentoSalesOrder::class,'sales_order_id');
    }


}
