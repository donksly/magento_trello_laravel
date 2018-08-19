<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = "module_suppliers";

    protected $fillable = ['name','url','email'];

    public function ordersRelationship()
    {
        return $this->belongsTo(Orders::class,'supplier_id');
    }
}
