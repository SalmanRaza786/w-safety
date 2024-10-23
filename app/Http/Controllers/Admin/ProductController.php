<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\category\CategoryInterface;
use App\Repositries\product\ProductInterface;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class ProductController extends Controller
{

    private $cat;
    private $product;

    public function __construct(CategoryInterface $cat,ProductInterface $product)
    {
        $this->cat = $cat;
        $this->product=$product;
    }

    public function index()
    {
        try {
            return view('admin.products.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }
    public function createProduct(Request $request)
    {
        try {
            $data=[];
            $data['isEdit']=0;
            $data['category']=Helper::fetchOnlyData($this->cat->getAllCategories());
            return view('admin.products.create')->with(compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    public function updateOrCreateRecord(Request $request)
    {

        try {
            $request->all();
            $roleUpdateOrCreate = $this->product->updateOrCreate($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function productsList(Request $request)
    {

        try {
            $res=$this->product->getProduct($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function editProduct($productId)
    {
        try {
            $data['product']=Helper::fetchOnlyData($this->product->findProductById($productId));
            $data['isEdit']=1;
            $data['category']=Helper::fetchOnlyData($this->cat->getAllCategories());
            return view('admin.products.create')->with(compact('data'));

        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function deleteProduct(Request $request)
    {
        try {
            $res = $this->product->deleteProduct($request->id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
