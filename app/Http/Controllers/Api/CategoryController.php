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

    public function getAllCountries(Request $request)
    {
        try {
            $countries = $this->cat->getAllCountries();
            if($countries['status']){
                return  Helper::createAPIResponce(false,200,'Countries list!',Helper::fetchOnlyData($countries));
            }else{
                return  Helper::createAPIResponce(true,400,$countries['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    public function getAllCategories(Request $request)
    {
        try {
            $countries = $this->cat->getAllCategories();
            if($countries['status']){
                return  Helper::createAPIResponce(false,200,'Categories list',Helper::fetchOnlyData($countries));
            }else{
                return  Helper::createAPIResponce(true,400,$countries['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    public function getAllSliders(Request $request)
    {
        try {
            $countries = $this->cat->getAllSliders();
            if($countries['status']){
                return  Helper::createAPIResponce(false,200,'Slider list!',Helper::fetchOnlyData($countries));
            }else{
                return  Helper::createAPIResponce(true,400,$countries['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }


}
