<?php

namespace App\Repositries\order;

use App\Http\Helpers\Helper;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Slider;
use App\Traits\HandleFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use DataTables;


class OrderRepositry implements OrderInterface
{
    public function updateOrCreateOrder($request,$customerId,$isApi=null)
    {

        try {
            DB::beginTransaction();
            $id=0;
            $order = Order::updateOrCreate(
                [
                    'id' => 0
                ],
                [
                    'amount'=>$request->totalAmount,
                    'client_id' =>$customerId,
                    'status' => 2,
                ]
            );
            foreach ($request->p_id as $key => $product) {
                $orderItem = OrderItem::updateOrCreate(
                    [
                        'id' => 0
                    ],
                    [

                        'order_id' =>$order->id,
                        'product_id' =>($isApi==1)?$request->p_id[$key]:decrypt( $request->p_id[$key]),
                        'qty' =>  $request->qty[$key],
                    ]
                );
            }

            ($id==0)?$message = __('translation.record_created'): $message =__('translation.record_updated');
            DB::commit();

            return Helper::success($orderItem, $message);
        }  catch (\Exception $e) {
            DB::rollBack();
            return Helper::errorWithData($e->getMessage(),[]);
        }
    }
    public function getAllOrders($customerId=null)
    {
        try {

            $qry= Order::query();
            ($customerId)?$qry->where('client_id',$customerId):'';
            ($customerId)? $data =$qry->paginate(10):$data =$qry->get();;
            return Helper::success($data, $message="Record found");

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }
}
