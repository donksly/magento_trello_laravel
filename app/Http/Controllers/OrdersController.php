<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    protected $magento_admin_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/';

    protected $single_order_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/sales/order/view/order_id/';

    public function index(){
        return view('home');
    }

    public function indexImport(){
        return view('import');
    }

    public function getStatusColorCodes(){
        $action = array("CREATED", "SHIPPED", "DELIVERED", "CLOSED", "ASKED RETURN", "RETURNED", "PROBLEMATIC");
        $action_keys = array(1,2,3,4,5,6,7);
        $colors = array("cadetblue", "cornflowerblue", "#007bff", "lightgreen", "lightpink", "deeppink", "firebrick");
        $combined = array_combine($action_keys,$colors);
        return $combined;
    }

    public function loadSupplierModal(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id,
            $request->supplier_id
        );
        return view('modal_add_update_supplier', compact('request_values'));
    }

    public function loadReturnModal(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id
        );
        return view('modal_return_actions', compact('request_values'));
    }

    public function loadSingleOrder(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id,
            $request->order_has_violations
        );
        return view('modal_view_order', compact('request_values'));
    }
}
