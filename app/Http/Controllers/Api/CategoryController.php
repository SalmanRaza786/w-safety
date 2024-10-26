<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\User;
use App\Repositries\category\CategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $cat;

    public function __construct(CategoryInterface $cat)
    {
        $this->cat = $cat;
    }


    public function getAllCategories(Request $request)
    {
        try {
            $countries = $this->cat->getAllCategories();
            if ($countries['status']) {
                return Helper::createAPIResponce(false, 200, 'Categories list', Helper::fetchOnlyData($countries));
            } else {
                return Helper::createAPIResponce(true, 400, $countries['message'], []);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    //saveCompanyInfo
    public function saveCompanyInfo(Request $request)
    {
        try {
             $request->all();
            $roleUpdateOrCreate = $this->cat->saveCompanyInfo($request);
            if ($roleUpdateOrCreate->get('status')) {
                return Helper::createAPIResponce(false, 200, $roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
            }else{
                return Helper::createAPIResponce(true, 400, $roleUpdateOrCreate->get('message'), []);
            }
        } catch (\Exception $e) {
            return Helper::createAPIResponce(true, 400,$roleUpdateOrCreate->get('message'),[]);
        }
    }

    public function saveCategory(Request $request)
    {
        try {
            $request->all();
            $roleUpdateOrCreate = $this->cat->saveCategory($request);
            if ($roleUpdateOrCreate->get('status')) {
                return Helper::createAPIResponce(false, 200, $roleUpdateOrCreate->get('message'), $roleUpdateOrCreate->get('data'));
            }else{
                return Helper::createAPIResponce(true, 400, $roleUpdateOrCreate->get('message'), []);
            }
        } catch (\Exception $e) {
            return Helper::createAPIResponce(true, 400,$roleUpdateOrCreate->get('message'),[]);
        }
    }


}

