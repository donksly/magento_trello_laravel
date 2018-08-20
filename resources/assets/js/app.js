window.$ = window.jQuery = require('jquery');
require('datatables.net-bs4');
require('bootstrap');
var defaultError = 'Error in request, contact developer.';
var timerVal = 0;
var duration = 3000;

$(document).ready(function(){
    /**Scroll top start**/
    var offset = 300,
        offset_opacity = 1200,
        scroll_top_duration = 700,
        $back_to_top = $('.cd-top');

    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $back_to_top.addClass('cd-fade-out');
        }
    });

    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
                scrollTop: 0 ,
            }, scroll_top_duration
        );
    });
    /**Scroll top stop**/

    $('#all_orders_table').DataTable();

    $('body').on('click', '#open-modal-supplier', function(a){
        a.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var order_table_id = $(this).attr('data-order-table-id');
        var supplier_id = $(this).attr('data-supplier-id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'post',
            url: '/open_supplier_modal',
            data: {
                _token: CSRF_TOKEN,
                order_id: order_id,
                order_table_id: order_table_id,
                supplier_id:supplier_id
            }, success: function (d) {
                $('.modal-content').html(d);
            }, error: function(e){
                toast_message(defaultError);
            }
        });
    });

    $('body').on('click', '#open-modal-reject-open', function(a){
        a.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var order_table_id = $(this).attr('data-order-table-id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'post',
            url: '/open_return_modal',
            data: {
                _token: CSRF_TOKEN,
                order_id: order_id,
                order_table_id: order_table_id
            }, success: function (d) {
                $('.modal-content').html(d);
            }, error: function(e){
                toast_message(defaultError);
            }
        });
    });

    $('body').on('click', '#open-modal-view-single-order', function(a){
        a.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var order_table_id = $(this).attr('data-order-table-id');
        var order_has_violations = $(this).attr('data-has-violations');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'post',
            url: '/open_single_order_modal',
            data: {
                _token: CSRF_TOKEN,
                order_id: order_id,
                order_table_id: order_table_id,
                order_has_violations: order_has_violations
            }, success: function (d) {
                $('.modal-content').html(d);
            }, error: function(e){
                toast_message(defaultError);
            }
        });
    });

});

function toast_message(message) {
    var x = document.getElementById("snackbar");
    $(x).html('<i class="fa fa-info-circle fa-lg"></i> '+message);
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function checkAnyChanges(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'post',
        url: '/check_any_change',
        data: {
            _token: CSRF_TOKEN
        }, success: function (d) {
            if (d == 1) {
                //if it hits 1 update div
            }else{
                //do Not update the div, remove all and set html to blank
            }
            //ret_data = d;
        }, error: function(err) {
            $('.callback-response-div').html(err);
        }
    });
}
