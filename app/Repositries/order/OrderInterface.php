<?php


namespace App\Repositries\order;
interface OrderInterface
{

    public function getAllOrders($customerId);
    public function updateOrCreateOrder($request,$customerId,$isApi);



}
