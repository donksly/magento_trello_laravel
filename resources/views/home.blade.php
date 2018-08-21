@extends('layouts.index')

@section('content')
    <div class="all-orders-table-div">
        <div class="display-new-orders">
        </div>
        <br>
        <table id="all_orders_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Order number</th>
                <th>Total purchased</th>
                <th>Status</th>
                <th>Supplier</th>
                <th>Return</th>
                <th>View</th>
                <th>Magento</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Order number</th>
                <th>Total purchased</th>
                <th>Status</th>
                <th>Supplier</th>
                <th>Return</th>
                <th>View</th>
                <th>Magento</th>
            </tr>
            </tfoot>
            <tbody>
            @if($get_all_orders != null)
                <?php
                $i = 1;
                ?>
                @foreach($get_all_orders as $order)
                    <tr>
                        <td>
                            @if($order->viewed == 0)
                                <span id="viewed-icon">
                                    <i class="fa fa-circle"></i>
                                </span>
                                @endif
                            {{ $i++ }}
                        </td>
                        <td>#{{ $helper->formatOrderNumberForView($order->sales_order_id) }}</td>
                        <td>
                            {{ ucwords(strtolower($order->fetchMagentoOrders->base_currency_code)).' '.(round($order->fetchMagentoOrders->base_grand_total, 2)) }}
                        </td>
                        <td><a href="javascript:;" class="btn btn-primary" id="status-color-created"
                               style="background-color: {{ $helper->getStatusColorCode($order->status) }} ;"></a></td>
                        <td>
                            <a href="" id="open-modal-supplier" data-supplier-id="{{ $order->supplier_id }}" data-order-table-id="{{ $order->id }}"
                               data-order-id="{{ $order->sales_order_id }}"
                               data-long-order-id="{{  $helper->formatOrderNumberForView($order->sales_order_id) }}"
                               data-toggle="modal" data-target="#primary_modal">
                                @if($order->supplier_id==0)
                                    <b>
                                        <i class="fa fa-truck"></i>
                                    </b>
                                @else
                                    {{ $order->ordersSupplierRelationship->name }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @if($order->closed_check == 0)
                                <a href="" id="open-modal-reject-open" data-order-table-id="{{ $order->id }}"
                                   data-order-id="{{ $order->sales_order_id }}"
                                   data-long-order-id="{{  $helper->formatOrderNumberForView($order->sales_order_id) }}"
                                   data-toggle="modal" data-target="#primary_modal">
                                    <i class="fa fa-backward"></i>
                                </a>
                                @else
                                    <i id="closed_order_icon" class="fa fa-lock"></i>
                            @endif
                        </td>
                        <td>
                            <a href="" id="open-modal-view-single-order"
                               data-order-table-id="{{ $order->id }}"
                               data-order-id="{{ $order->sales_order_id }}"
                               data-has-violations = "{{ $order->error_log}}"
                               data-long-order-id="{{  $helper->formatOrderNumberForView($order->sales_order_id) }}"
                               data-purchase-point = "{{ ($order->fetchMagentoOrders->ordersSalesInvoice->store_name) }}"
                               data-purchase-date = "{{ (ucwords($helper->formatDateTimeWithSeconds($order->fetchMagentoOrders->created_at))) }}"
                               data-customer-name = "{{ ucwords($order->fetchMagentoOrders->customer_firstname.' '.
                               $order->fetchMagentoOrders->customer_middlename.' '.$order->fetchMagentoOrders->customer_lastname) }}"
                               data-customer-email = "{{ $order->fetchMagentoOrders->customer_email }}"
                               data-currency = "{{ $order->fetchMagentoOrders->base_currency_code }}"
                               data-grand-total = "{{ $order->fetchMagentoOrders->base_grand_total }}"
                               data-current-state = "{{ $helper->getCurrentOrderStatus($order->status) }}"
                               data-current-state-color = "{{ $helper->getStatusColorCode($order->status) }}"
                               data-supplier-id="{{ $order->supplier_id }}"
                               data-toggle="modal" data-target="#primary_modal">
                            @if($order->error_log == '')
                                    <i class="fa fa-mouse-pointer"></i>
                                @else
                                    <i class="fa fa-exclamation-triangle" id="error-in-logs"></i>
                            @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ $single_order_url.$order->sales_order_id }}/" target="_blank" id="view-order-in-magento"
                               class="img-responsive">
                                <img src="{{ asset('images/magento_logo.png') }}" alt="Go">
                            </a>
                        </td>
                    </tr>
                    @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <br>
    <div class="article-status-color-legend">
        <h5>Status color codes</h5>
        <table class="table table-striped table-bordered" cellspacing="0" width="30%">
            <thead>
                <tr>
                    <th>ACTION</th>
                    <th>COLOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CREATED</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-created"></a></td>
                </tr>
                <tr>
                    <td>SHIPPED</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-shipped"></a></li></td>
                </tr>
                <tr>
                    <td>DELIVERED</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-delivered"></a></td>
                </tr>
                <tr>
                    <td>CLOSED</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-closed"></a></td>
                </tr>
                <tr>
                    <td>ASKED RETURN</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-asked-return"></a></td>
                </tr>
                <tr>
                    <td>RETURNED</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-created-returned"></a></td>
                </tr>
                <tr>
                    <td>PROBLEMATIC</td>
                    <td><a href="javascript:;" class="btn btn-primary" id="status-color-problematic"></a></td>
                </tr>
            </tbody>
        </table>
   </div>
    @endsection
<script src="{{asset('js/app.js')}}"></script>
<script>
    var duration = 3000;

    $(document).ready(function() {
        $('#link_all_orders').attr('class', 'active');
        $('#page_header_title').html('<i class="fa fa-list"></i> All Orders');

        timerIdRandId = setInterval(function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            checkAnyChanges(CSRF_TOKEN);
        }, duration);

        $.ajax({
            type: 'post',
            url: '/close_old_delivered_articles',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content')
            }, success:function(data){
                if(data == 1){
                    console.log('Old delivered articles closed');
                }
            }
        });

    });

    function checkAnyChanges(CSRF_TOKEN){
        $.ajax({
            type: 'post',
            url: '/check_new_orders',
            data:{
                _token: CSRF_TOKEN
            }, success:function(data){
                if(data == 0){
                    $('.display-new-orders').html('');
                }else{
                    var orders = "order";
                    if(data>1){orders = "orders";}
                    $('.display-new-orders').html('<code>You have '+data+' '+ orders+' pending review.</code><a href="/" id="reload-all-orders"> Sync all</a>');
                }
            }
        });
    }
</script>
