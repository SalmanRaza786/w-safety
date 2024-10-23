<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Repositries\order\OrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;


class CustomerController extends Controller
{
    private $order;


    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }
    public function myAc(Request $request)
    {

        try {
            $data['orders']=Helper::fetchOnlyData($this->order->getAllOrders(Auth::user()->id));
       return view('web.my-ac')->with(compact('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
