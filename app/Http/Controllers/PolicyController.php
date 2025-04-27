<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function orderPolicy()
    {
        return view('client.order_policy');
    }
}
