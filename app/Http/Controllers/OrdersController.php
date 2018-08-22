<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\MagentoSalesOrder;
use App\Orders;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    protected $magento_admin_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/';
    protected $single_order_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/sales/order/view/order_id/';
    protected $er_admin_email = 'er_admin@stockly.ai';
    protected $state = array("CREATED", "SHIPPED", "DELIVERED", "CLOSED", "ASKED RETURN", "RETURNED", "PROBLEMATIC");
    protected $action_keys = array(1,2,3,4,5,6,7);
    protected $colors = array("cadetblue", "cornflowerblue", "#007bff", "lightgreen", "lightpink", "deeppink", "firebrick");

    protected $magento_state = array(1 => "new","processing","closed");
    protected $magento_status = array(1 => "pending","processing","closed");

    public function index(Helpers $helper){
        $get_all_orders = Orders::all()->sortBy('id');
        return view('home', compact('get_all_orders'))->with('helper', $helper)
            ->with('single_order_url', $this->single_order_url)
            ->with('magento_admin_url', $this->magento_admin_url);
    }

    public function indexImport(){
        return view('import')->with('magento_admin_url', $this->magento_admin_url);
    }

    public function checkNewOrdersMagento(Helpers $helpers){
        $get_all_orders = $this->fetchAllOrdersFromMagento();
        $unseen_count = 0;

        foreach($get_all_orders as $single_order){
            $single_order = json_decode($single_order);
            for($i=0; $i<sizeof($single_order); $i++){

            $get_single_order = Orders::all()->where('sales_order_id','=',$single_order[$i]->entity_id)
                ->where('closed_check','=',0)->first();

            if($get_single_order == null){
                Orders::create([
                    'sales_order_id' => $single_order[$i]->entity_id,
                    'supplier_id' => 0,
                    'previous_state' => 1,
                    'status' => 1,
                    'error_log' => ''
                ]);

                $client_mail = $this->fetchSingleOrder($single_order[$i])->customer_email;
                $message = "Your order has been accepted, your order number is #".
                    $helpers->formatOrderNumberForView($single_order[$i]->entity_id);

                $helpers->sendEmail($client_mail, 'E-Retailer - Order Accepted', $message);

            }

            $all_unseen_updates = Orders::all()->where('viewed','=',0)->groupBy('id')->count();

            if($all_unseen_updates != 0){
                $unseen_count = $all_unseen_updates;
            }

            }
        }
        return $unseen_count;
    }

    public function getStatusColorCodes(){
        $combined = array_combine($this->action_keys,$this->colors);
        return $combined;
    }

    public function loadSupplierModal(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id,
            $request->supplier_id
        );
        $all_orders = $this->fetchAllSuppliers();
        return view('modal_add_update_supplier', compact('request_values','all_orders'));
    }

    public function loadReturnModal(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id,
            $request->supplier_id
        );
        return view('modal_return_actions', compact('request_values'));
    }

    public function loadSingleOrder(Request $request){
        $request_values = array(
            $request->order_id,
            $request->order_table_id,
            $request->order_has_violations,
            $request->long_order_id,
            $request->purchase_point,
            $request->purchase_date,
            $request->customer_name,
            $request->customer_email,
            $request->grand_total,
            $request->state,
            $request->state_color,
            $request->supplier_id,
            $request->currency
        );
        $order_id = $request->order_table_id;

        $find_order = Orders::all()->where('id','=',$order_id)->first();
        $find_order->update(['updated_at' => null, 'viewed' => 1]);

        return view('modal_view_order', compact('request_values'));
    }

    public function fetchAllSuppliers(){
        $fetch_all = Suppliers::all();
        return $fetch_all;
    }

    public function fetchAllOrdersFromMagento(){
        $fetch_all = MagentoSalesOrder::all()->groupBy('entity_id');
        return $fetch_all;
    }

    public function fetchSingleOrder($order_id){
        $fetch_all = MagentoSalesOrder::all()->where('entity_id','=',$order_id)->first();
        return $fetch_all;
    }

    public function getSingleOrderSpecifics($order_id){
        $all_order_details = $this->fetchSingleOrder($order_id);
        $total_paid = $all_order_details->base_grand_total;
        $return_array = array($total_paid);
        return $return_array;
    }

    public function closeOldDeliveredArticles(){
        $fetch_old_delivered_ordes = MagentoSalesOrder::all()->where('created_at', '>=', Carbon::now()->subDays(2))
            ->where('state','=','delivered');
        foreach($fetch_old_delivered_ordes as $single_delivered_order){
            $single_order = json_decode($single_delivered_order);
            for($i=0; $i<sizeof($single_order); $i++) {

                $close_order_magento = MagentoSalesOrder::all()->where('entity_id', '=', $single_order[$i]->entity_id)->first();
                $close_order_magento->update(['updated_at' => null, 'state' => 'closed', 'status' => 'closed']);

                $close_order_module = Orders::all()->where('sales_order_id', '=', $single_order[$i]->entity_id)->first();
                $close_order_module->update(['updated_at' => null, 'closed_check' => 1, 'status' => 4]);
            }
        }
        return 1;
    }

    public function createOrUpdateSupplier(Request $request, Helpers $helpers){
        $order_id = $request->order_id;
        $order_table_id = $request->order_table_id;
        $supplier_id = $request->modal_new_supplier;

        $find_order = Orders::all()->where('id','=',$order_id)->first();
        $find_order->update(['updated_at' => null, 'supplier_id' => $supplier_id]);

        $supplier = new SuppliersController();
        $supplier_email = $supplier->getSingleSupplierById($supplier_id);
        $message = "You have a new order #".$helpers->formatOrderNumberForView($order_id);


        $helpers->sendEmail($supplier_email->email, 'E-Retailer - New supplier', $message);

        $flash_message = $helpers->setMessageSession("Supplier successfully added to order.");
        return back();
    }

    public function requestReturnArticle(Request $request, Helpers $helpers){
        $order_id = $request->order_id;
        $supplier_id = $request->supplier_id;

        $supplier = new SuppliersController();
        $supplier_email = $supplier->getSingleSupplierById($supplier_id);
        $message = "You have an article return request for #".$order_id;


        $helpers->sendEmail($supplier_email->email, 'E-Retailer - Return Article Request', $message);

        $flash_message = $helpers->setMessageSession("Return request sent successfully!");
        return back();

    }

    public function fixSingleImpossibleEvaluation(Request $request, Helpers $helpers){
        $order_id = $request->order_id;
        $supplier_id = $request->modal_current_supplier;

        //////////////////////ensure you've a method to only pass NON-CLOSED ITEMS through this filter

        $ok_to_update = $this->checkImpossibleEvaluationAlgorithm($order_id, $request->new_state);
        $find_order = Orders::all()->where('id','=',$order_id)->first();

        if($ok_to_update == 1){

            $close_order_magento = MagentoSalesOrder::all()->where('entity_id', '=', $find_order->sales_order_id)->first();
            if($request->new_state == 4){
                $close_order_magento->update(['updated_at' => null, 'state' => 'closed', 'status' => 'closed']);
            }
            $find_order->update(['updated_at' => null, 'previous_state' => $find_order->next_state, 'next_state' => $request->new_state]);

            $supplier = new SuppliersController();
            $supplier_email = $supplier->getSingleSupplierById($supplier_id);
            $message = "This order #".$helpers->formatOrderNumberForView($order_id)." had evaluation errors and was fixed!";

            $helpers->sendEmail($supplier_email->email, 'E-Retailer - Impossible Evaluation', $message);

        }else{
            $find_order->update(['updated_at' => null, 'error_log' => 'ERROR: Impossible evaluation detected!']);
        }

        ///////////////////////////send to trello api updated ver

        return $ok_to_update;
    }

    public function checkImpossibleEvaluationAlgorithm($order_id, $new_state){
        $get_order_details = Orders::all()->where('id','=',$order_id)->first();
        $order_previous_state = $get_order_details->next_state;
        $order_next_state = $new_state;

        $update_ok = 1;

        $compare_arrays = array(
            array(3,5,6,7),
            array(1,4,5,6,7),
            array(1,2),
            array(1,2,3,5,6,7),
            array(1,2,3),
            array(1,2,3,5,7),
            array(1,2,3)
        );

        for($i=1; $i<sizeof($compare_arrays)+1; $i++){
            switch ($update_ok)
            {
                case ($order_previous_state == $i && in_array($order_next_state, $compare_arrays[$i-1]));
                    $update_ok = 0;
                    break;
            }
        }

        return $update_ok;
    }




}
