<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = "module_suppliers";

    protected $fillable = ['name','url','email'];


}
