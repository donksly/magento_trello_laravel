<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Helpers extends Model
{
    protected $colors = array(1 => "cadetblue", "cornflowerblue", "#007bff", "lightgreen", "lightpink", "deeppink", "firebrick");
    protected $state = array(1 => "CREATED", "SHIPPED", "DELIVERED", "CLOSED", "ASKED RETURN", "RETURNED", "PROBLEMATIC");

    public function formatDateTimeWithSeconds($the_string){
        return date("F jS, Y - g:ia", strtotime($the_string));
    }

    public function formatDateTimeOnly($the_string){
        return date("F jS, Y", strtotime($the_string));
    }

    public function formatOrderNumberForView($number){
        return str_pad($number, 8, "0", STR_PAD_LEFT);
    }

    public function getStatusColorCode($status){
        $color = 'white';
        switch($status)
        {
            case $status == 1:
                $color = $this->colors[1];
                break;
            case $status == 2:
                $color = $this->colors[2];
                break;
            case $status == 3:
                $color = $this->colors[3];
                break;
            case $status == 4:
                $color = $this->colors[4];
                break;
            case $status == 5:
                $color = $this->colors[5];
                break;
            case $status == 6:
                $color = $this->colors[6];
                break;
            case $status == 7:
                $color = $this->colors[7];
                break;
        }
        return $color;
    }

    public function getCurrentOrderStatus($status_id){
        $state = 'CREATED';
        switch($state)
        {
            case $status_id == 1:
                $state = $this->state[1];
                break;
            case $status_id == 2:
                $state = $this->state[2];
                break;
            case $status_id == 3:
                $state = $this->state[3];
                break;
            case $status_id == 4:
                $state = $this->state[4];
                break;
            case $status_id == 5:
                $state = $this->state[5];
                break;
            case $status_id == 6:
                $state = $this->state[6];
                break;
            case $status_id == 7:
                $state = $this->state[7];
                break;
        }
        return $state;
    }

    public function sendEmail($to,$subject,$messages)
    {
        $args = array('email' => $to, 'subject' => $subject, 'message' => $messages);
        Mail::raw($args['message'], function($message) use ($args) {
            $message->to($args['email'], 'E-Retailer')->subject
            ($args['subject']);
            $message->from('e-retailer@stockly.com','E-Retailer Supplier');
        });
    }

    public function setMessageSession($message){
        return Session::flash('returned_flash_message', $message);
    }
}
