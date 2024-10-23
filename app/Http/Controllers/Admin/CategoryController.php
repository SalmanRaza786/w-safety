<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Repositries\category\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $cat;

    public function __construct(CategoryInterface $cat)
    {
        $this->cat = $cat;
    }

    public function index()
    {
        try {

            return view('admin.category.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    public function updateOrCreateRecord(Request $request)
    {

        try {
             $request->all();
            $roleUpdateOrCreate = $this->cat->updateOrCreate($request,$request->id);
            if ($roleUpdateOrCreate->get('status'))
                return Helper::ajaxSuccess($roleUpdateOrCreate->get('data'),$roleUpdateOrCreate->get('message'));
            return Helper::ajaxErrorWithData($roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function getCategory(Request $request)
    {

        try {
            $res=$this->cat->getCategory($request);
            return Helper::ajaxDatatable($res['data']['data'], $res['data']['totalRecords'],$request);
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }

    public function editCategory(Request $request)
    {
        try {
            $res= $this->cat->findCategoryById($request->id);
            if($res->get('data')){
                return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
            }else{
                return Helper::ajaxError('Record not found');
            }
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
    public function deleteCategory(Request $request)
    {
        try {
            $res = $this->cat->deleteCategory($request->id);
            return Helper::ajaxSuccess($res->get('data'),$res->get('message'));
        } catch (\Exception $e) {
            return Helper::ajaxError($e->getMessage());
        }
    }
}
