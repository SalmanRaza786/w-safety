<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\product\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    public function getAllProducts(Request $request)
    {
        try {
            $products = $this->product->getAllProduct();
            if($products['status']){
                $productData=collect([]);

                foreach ($products->get('data') as $row){
                    $array=array(
                        'id'=>$row->id,
                        'title'=>$row->title,
                        'price'=>$row->price,
                        'description'=>$row->description,
                        'image' =>URL::asset('storage/uploads/').'/'.$row->thumbnail,
                    );
                    $productData->push($array);
                }
                return $productData;
                return  Helper::createAPIResponce(false,200,'Products list',Helper::fetchOnlyData($products));
            }else{
                return  Helper::createAPIResponce(true,400,$products['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }
}
