@extends('layouts.index')

@section('content')
    <div class="all-orders-table-div">
        <div class="display-new-orders">
            <code>You have 3 new orders.</code>
            <a href="{{ url('/') }}" id="reload-all-orders">
                 Sync all
            </a>
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
            <tr>
                <td>
                    <span id="viewed-icon">
                        <i class="fa fa-circle"></i>
                    </span>
                    1
                </td>
                <td>00000000001</td>
                <td>5,600</td>
                <td><a href="javascript:;" class="btn btn-primary" id="status-color-created"></a></td>
                <td>
                    <a href="" id="open-modal-supplier" data-supplier-id="2" data-order-table-id="1" data-order-id="000000002" data-toggle="modal" data-target="#primary_modal">
                        <b>B</b>
                        <i class="fa fa-truck"></i>
                    </a>
                </td>
                <td>
                    <a href="" id="open-modal-reject-open" data-order-table-id="1" data-order-id="000000002" data-toggle="modal" data-target="#primary_modal">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
                <td>
                    <a href="" id="open-modal-view-single-order" data-has-violations="1" data-order-table-id="1" data-order-id="000000002" data-toggle="modal" data-target="#primary_modal">
                        <i class="fa fa-exclamation-triangle" id="error-in-logs"></i>
                        <i class="fa fa-mouse-pointer"></i>
                    </a>
                </td>
                <td>
                    <a href="" target="_blank" id="view-order-in-magento" class="img-responsive">
                        <img src="{{ asset('images/magento_logo.png') }}" alt="Go">
                    </a>
                </td>
            </tr>
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
    $(document).ready(function() {
        $('#link_import').attr('class', 'active');
        $('#page_header_title').html('<i class="fa fa-list"></i> All Orders');

        //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        /*$.ajax({
            type: 'post',
            url: '/check_new_orders',
            data:{
                _token: CSRF_TOKEN
            }, success:function(data){
                $('.callback-response-div').html(data);
                //timeout to check payment
                if(data!=''){
                    alert('sdsdds');
                    timerIdRandId = setInterval(function () {
                        checkAnyChanges();
                    }, duration);
                }
            }, error: function(err){
                //comment out in production
                $('.callback-response-div').html(err);
            }
        });*/


    });
</script>
