<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SuppliersController extends Controller
{
    public function index(){
        return view('suppliers');
    }

    public function createSuppliers(Request $request){
        $supplier_name_id = $request->new_supplier_name;
        $supplier_url = $request->new_supplier_url;
        $supplier_email = $request->new_supplier_email;

        $get_supplier_name = $this->convertSupplierId($supplier_name_id);

        $find_supplier = Suppliers::all()->where('name','=',$get_supplier_name)->first();
        $message = "Supplier '.$get_supplier_name.' added successfully.";
        if($find_supplier == null){
            Suppliers::create([
               'name' => $get_supplier_name,
               'url' => $supplier_url,
               'email' => $supplier_email
            ]);
        }else{
            $find_supplier->update(['updated_at' => null, 'url' => $supplier_url, 'email' => $supplier_email]);
            $message = "Supplier ".$get_supplier_name." updated successfully.";
        }

        $this->setMessageSession($message);
        return back();
    }

    public function convertSupplierId($supplier_id){
        $supplier_name = array(1 => "A",2 => "B");
        return $supplier_name[$supplier_id];
    }

    public function setMessageSession($message){
        Session::flash('returned_flash_message', $message);
    }
}
