<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpers extends Model
{
    public function formatDateTimeWithSeconds($the_string){
        return date("F jS, Y - g:ia", strtotime($the_string));
    }

    public function formatDateTimeOnly($the_string){
        return date("F jS, Y", strtotime($the_string));
    }
}
