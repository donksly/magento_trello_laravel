<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order', function (Blueprint $table){
            $table->increments('entity_id');
            $table->string('state', 50);
            $table->string('status', 50);
            $table->string('coupon_code', 50);
            $table->string('protect_code', 50);
            $table->string('shipping_description', 50);
            $table->string('is_virtual', 50);
            $table->string('store_id', 50);
            $table->string('customer_id', 50);
            $table->string('base_discount_amount', 50);
            $table->string('base_discount_canceled', 50);
            $table->string('base_discount_invoiced', 50);
            $table->string('base_discount_refunded', 50);
            $table->string('base_grand_total', 50);
            $table->string('base_shipping_amount', 50);
            $table->string('base_shipping_canceled', 50);
            $table->string('base_shipping_invoiced', 50);
            $table->string('base_shipping_refunded', 50);
            $table->string('base_shipping_tax_amount', 50);
            $table->string('base_shipping_tax_refunded', 50);
            $table->string('base_subtotal', 50);
            $table->string('base_subtotal_canceled', 50);
            $table->string('base_subtotal_invoiced', 50);
            $table->string('base_subtotal_refunded', 50);
            $table->string('base_tax_amount', 50);
            $table->string('base_tax_canceled', 50);
            $table->string('base_tax_invoiced', 50);
            $table->string('base_tax_refunded', 50);
            $table->string('base_to_global_rate', 50);
            $table->string('base_to_order_rate', 50);
            $table->string('base_total_canceled', 50);
            $table->string('base_total_invoiced', 50);
            $table->string('base_total_invoiced_cost', 50);
            $table->string('base_total_offline_refunded', 50);
            $table->string('base_total_online_refunded', 50);
            $table->string('base_total_paid', 50);
            $table->string('base_total_qty_ordered', 50);
            $table->string('base_total_refunded', 50);
            $table->string('discount_amount', 50);
            $table->string('discount_canceled', 50);
            $table->string('discount_invoiced', 50);
            $table->string('discount_refunded', 50);
            $table->string('grand_total', 50);
            $table->string('shipping_amount', 50);
            $table->string('shipping_canceled', 50);
            $table->string('shipping_invoiced', 50);
            $table->string('shipping_refunded', 50);
            $table->string('shipping_tax_amount', 50);
            $table->string('shipping_tax_refunded', 50);
            $table->string('store_to_base_rate', 50);
            $table->string('store_to_order_rate', 50);
            $table->string('subtotal', 50);
            $table->string('subtotal_canceled', 50);
            $table->string('subtotal_invoiced', 50);
            $table->string('subtotal_refunded', 50);
            $table->string('tax_amount', 50);
            $table->string('tax_canceled', 50);
            $table->string('tax_invoiced', 50);
            $table->string('tax_refunded', 50);
            $table->string('total_canceled', 50);
            $table->string('total_invoiced', 50);
            $table->string('total_offline_refunded', 50);
            $table->string('total_online_refunded', 50);
            $table->string('total_paid', 50);
            $table->string('total_qty_ordered', 50);
            $table->string('total_refunded', 50);
            $table->string('can_ship_partially', 50);
            $table->string('can_ship_partially_item', 50);
            $table->string('customer_is_guest', 50);
            $table->string('customer_note_notify', 50);
            $table->string('billing_address_id', 50);
            $table->string('customer_group_id', 50);
            $table->string('edit_increment', 50);
            $table->string('email_sent', 50);
            $table->string('send_email', 50);
            $table->string('forced_shipment_with_invoice', 50);
            $table->string('payment_auth_expiration', 50);
            $table->string('quote_address_id', 50);
            $table->string('quote_id', 50);
            $table->string('shipping_address_id', 50);
            $table->string('adjustment_negative', 50);
            $table->string('adjustment_positive', 50);
            $table->string('base_adjustment_negative', 50);
            $table->string('base_adjustment_positive', 50);
            $table->string('base_shipping_discount_amount', 50);
            $table->string('base_subtotal_incl_tax', 50);
            $table->string('base_total_due', 50);
            $table->string('payment_authorization_amount', 50);
            $table->string('shipping_discount_amount', 50);
            $table->string('subtotal_incl_tax', 50);
            $table->string('total_due', 50);
            $table->string('weight', 50);
            $table->string('customer_dob', 50);
            $table->string('increment_id', 50);
            $table->string('applied_rule_ids', 50);
            $table->string('base_currency_code', 50);
            $table->string('customer_email', 50);
            $table->string('customer_firstname', 50);
            $table->string('customer_lastname', 50);
            $table->string('customer_middlename', 50);
            $table->string('customer_prefix', 50);
            $table->string('customer_suffix', 50);
            $table->string('customer_taxvat', 50);
            $table->string('discount_description', 50);
            $table->string('ext_customer_id', 50);
            $table->string('ext_order_id', 50);
            $table->string('global_currency_code', 50);
            $table->string('hold_before_state', 50);
            $table->string('hold_before_status', 50);
            $table->string('order_currency_code', 50);
            $table->string('original_increment_id', 50);
            $table->string('relation_child_id', 50);
            $table->string('relation_child_real_id', 50);
            $table->string('relation_parent_id', 50);
            $table->string('relation_parent_real_id', 50);
            $table->string('remote_ip', 50);
            $table->string('shipping_method', 50);
            $table->string('store_currency_code', 50);
            $table->string('store_name', 50);
            $table->string('x_forwarded_for', 50);
            $table->string('customer_note', 50);
            $table->string('total_item_count', 50);
            $table->string('customer_gender', 50);
            $table->string('discount_tax_compensation_amount', 50);
            $table->string('base_discount_tax_compensation_amount', 50);
            $table->string('shipping_discount_tax_compensation_amount', 50);
            $table->string('base_shipping_discount_tax_compensation_amnt', 50);
            $table->string('discount_tax_compensation_invoiced', 50);
            $table->string('base_discount_tax_compensation_invoiced', 50);
            $table->string('discount_tax_compensation_refunded', 50);
            $table->string('base_discount_tax_compensation_refunded', 50);
            $table->string('shipping_incl_tax', 50);
            $table->string('base_shipping_incl_tax', 50);
            $table->string('coupon_rule_name', 50);
            $table->string('paypal_ipn_customer_notified', 50);
            $table->string('gift_message_id', 50);
            $table->timestamps(, 50);
        }, 50);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
