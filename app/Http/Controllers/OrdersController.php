<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\MagentoSalesOrder;
use App\Orders;
use App\Suppliers;
//use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth1\Client\Server\Trello;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use League\OAuth1\Client\Server\Server;
use Trello\Api\Board\Cardlists;
use Trello\Api\Cardlist\Cards;
use Trello\Api\Member\Boards;
use Trello\Client;
use Trello\Manager;

class OrdersController extends Controller
{
    protected $magento_admin_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/';
    protected $single_order_url = 'http://127.0.0.1/Magento-CE-2.2.5/admin_a27nw8/sales/order/view/order_id/';
    protected $er_admin_email = 'er_admin@stockly.ai';
    protected $state = array("CREATED", "SHIPPED", "DELIVERED", "CLOSED", "ASKED RETURN", "RETURNED", "PROBLEMATIC");
    protected $state_in_trello = array(1 => "CREATED", "SHIPPED", "DELIVERED", "CLOSED", "ASKED_RETURN", "RETURNED", "PROBLEMATIC");
    protected $action_keys = array(1,2,3,4,5,6,7);
    protected $colors = array("cadetblue", "cornflowerblue", "#007bff", "lightgreen", "lightpink", "deeppink", "firebrick");

    protected $live_url = 'https://stocklyretailer.herokuapp.com/';
    protected $live_url_api = 'https://stocklyretailer.herokuapp.com/api/';
    protected $trello_identifier = '4ff88df6485dd26e226982183a361880';
    protected $trello_secret = '7c23575bd820e6716e28bf3db142929d48a056caac35f38bb03f21c2664b2752';
    protected $trello_application_name = 'StocklyERetailer';

    protected $magento_state = array(1 => "new","processing","closed");
    protected $magento_status = array(1 => "pending","processing","closed");

    protected $suppliers = array(1 => "Supplier A","Supplier B");

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

    public function fetchTrelloToken(){
        return Socialite::with('trello')->scopes(['read', 'write'])->redirect();
    }

    public function fetchTrelloTokenCallback(){
        $user = Socialite::driver('trello')->user();
        $accessTokenResponseBody = $user->accessTokenResponseBody;

        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            $temporaryCredentials = unserialize(Session::get('temporary_credentials'));
        }

        $oauth_token = $accessTokenResponseBody['oauth_token'];
        $oauth_token_secret = $accessTokenResponseBody['oauth_token_secret'];
        Session::flash('oauth_token',$oauth_token);

        return $this->trelloFetchAllBoards();
    }



    public function trelloFetchAllBoards()
    {
        $oauth_token = Session::get('oauth_token');
        $client = new Client();

        $token = $oauth_token;
        $client->authenticate($this->trello_identifier, $token, Client::AUTH_URL_CLIENT_ID);

        $boards = $client->api('member')->boards()->all("me", array());

        $all_boards = json_encode($boards);
        $supplier_a_board = json_encode($boards[0]);
        $supplier_b_board = json_encode($boards[1]);

        foreach ($boards as $board) {
            //Log::info(json_encode($board));
        }

        //////////////////Insert - DIRTY below
        $manager = new Manager($client);
        $card = $manager->getCard();

        /*$card
            ->setName('Test000005')
            // Go to you board in browser add ".json" at the end of the URL and search for the ID of the list you wont...
            ->setListId('5b76d7a80fb3d06141dcc0d6')
            ->setDescription('Main Store')
            ->save();*/

        ///Log::info(json_encode($manager->getAction('5b7dc71ed984dd6a3aa6f4f0')));

        //get all boards
        $supplier_array = array('Supplier A', 'Supplier B');
        $i = 0;
        $final_card = array();
        for ($i = 0; $i < sizeof($boards); $i++) {
            ////Log::info($boards[$i]['id']);
            /////$lists = $client->api('board')->lists()->all($boards[$i]['id']);

            //get all lists
            //////$lists = json_encode($client->api('board')->lists()->all($boards[$i]['id']));
            //////Log::info($lists);
            $board_id = $boards[$i]['id'];
            $board_name = $boards[$i]['name'];
            $lists = ($client->api('board')->lists()->all($boards[$i]['id']));
            foreach ($lists as $list) {
                //get all cards


                //Log::info(json_encode($list));
                //Log::info($list['id']);

                $list_id = $list['id'];
                $list_name = $list['name'];
                $cards = ($client->api('board')->cards()->all($boards[$i]['id']));
                //Log::info($board_name.' ----> '.$list_name.' ----> '.json_encode($cards));

                foreach ($cards as $single_card) {
                    $board_id = $single_card['idBoard'];
                    $card_level_board_name = $board_name;

                    $list_id = $single_card['idList'];
                    $card_level_list_name = $list_name;

                    $card_id = $single_card['id'];
                    $card_name = $single_card['name'];
                    $card_description = $single_card['desc'];
                    $close_default = $single_card['closed']; //false

                    //Log::info(json_encode($single_card));
                    $final_card[] = $single_card;


                }
            }
        }


        $all_orders = Orders::all();
        $helper = new Helpers();


        if (sizeof($final_card) == 0) {
            foreach ($all_orders as $order) {
                //push all from our db
                if ($order->supplier_id != 0) {
                    $get_supplier = $this->suppliers[$order->supplier_id];
                    $get_status_name = $helper->getCurrentOrderStatus($order->status);
                    $card_name = $helper->formatOrderNumberForView($order->sales_order_id);
                    $card_description = 'Created on: Order by: ' . $helper->formatDateTimeWithSeconds($order->created_at);

                    $close_default = 'false';

                    /*Log::info($helper->matchTrelloBoardId($order->supplier_id." -- ".$helper->matchTrelloListId($order->status, $order->supplier_id)
                        ." -- ".'Order #' . $helper->formatOrderNumberForView($order->sales_order_id)." -- ".$card_description));*/

                    Log::info($helper->matchTrelloBoardId($order->supplier_id)." -- ".$helper->matchTrelloListId($order->status, $order->supplier_id)
                        ." -- ".'Order #' . $helper->formatOrderNumberForView($order->sales_order_id)." -- ".$card_description);

                    $card
                        ->setBoardId($helper->matchTrelloBoardId($order->supplier_id))
                        ->setListId($helper->matchTrelloListId($order->status, $order->supplier_id))
                        ->setName('Order #' . $helper->formatOrderNumberForView($order->sales_order_id))
                        ->setDescription($card_description)
                        ->save();
                }
            }
        } else {
            //validate and sync pulled now, validate, update and push i.e update
            //foreach
        }
        return (json_encode($final_card));
        /////return json_encode($boards);

    }





}
