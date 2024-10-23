<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\order\OrderInterface;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $order;


    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }
    public function saveOrder(Request $request)
    {

        try {
            $request->all();
            $roleUpdateOrCreate = $this->order->updateOrCreateOrder($request,$request->customerId,1);
            if ($roleUpdateOrCreate->get('status')){
                return  Helper::createAPIResponce(false,200,'Order create successfully',Helper::fetchOnlyData($roleUpdateOrCreate));
            }else {
                return Helper::createAPIResponce(true, 400, $roleUpdateOrCreate['message'], []);
            }
        } catch (\Exception $e) {
                return  Helper::createAPIResponce(true,400,$roleUpdateOrCreate['message'],[]);
            }

    }
}
