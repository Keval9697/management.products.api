<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class productController extends snsController
{
    protected $topicName = "Products";

    function validation($message) {

        if(($message == "") or (!isset($message))){
            return false;
        }
        return true;
    }
}
