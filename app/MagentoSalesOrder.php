<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagentoSalesOrder extends Model
{
    protected $table = "sales_order";
    protected $guarded = [];
    protected $primaryKey = 'entity_id';

    public function ordersSalesInvoice()
    {
        return $this->belongsTo(MagentoSalesInvoiceGrid::class,'store_id');
    }


}
