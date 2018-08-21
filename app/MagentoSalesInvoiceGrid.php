<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagentoSalesInvoiceGrid extends Model
{
    protected $table = "sales_invoice_grid";
    protected $primaryKey = 'entity_id';

    public function ordersSalesOrder()
    {
        return $this->belongsToMany(MagentoSalesOrder::class,'order_id');
    }
}
