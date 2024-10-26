<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\Category;
use App\Models\CompanyInfo;
use App\Models\DeviceToken;
use App\Models\Student;
use App\Models\User;
use App\Repositries\customer\CustomerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $customer;

    public function __construct(CustomerInterface $customer) {
        $this->customer = $customer;

    }

    public function login(Request $request)
    {
        try {
             $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'latitude' => 'required',
                'langitude' => 'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }


                if (User::query()->where('email',$request->email)->first()){
                    return $response=$this->customerLogin($request);
                }

            return  Helper::createAPIResponce(true,400,'Invalid email',$request->all());



        } catch (\Exception $e) {
            return  Helper::createAPIResponce(true,400,$e->getMessage(),[]);

        }
    }

    public function customerLogin(Request $request)
    {
        try {

            $distanceInMeters = Helper::haversineGreatCircleDistance($request->latitude,$request->langitude);
            if($distanceInMeters['kilometers'] >  10){
                return  Helper::createAPIResponce(true,400,'You are out of range',$request->all());

            }
            if (!$user=Auth::guard('web')->attempt($request->only(['email','password']))) {
                return  Helper::createAPIResponce(true,400,'Invalid credentials',$request->all());
            }

            $data['user']=User::where('email',$request->email)->first();
            $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
            return  Helper::createAPIResponce(false,200,'Logged in successfully',$data);

        } catch (\Exception $e) {
            throw $e;

        }
    }


    public function customerSignups(Request $request)
    {
        try {

             $request->all();
              $distanceInMeters = Helper::haversineGreatCircleDistance($request->latitude,$request->langitude);
              if($distanceInMeters==404){
                  return  Helper::createAPIResponce(true,400,'Company info missing',$request->all());
              }
            if($distanceInMeters['kilometers'] >  10){
                return  Helper::createAPIResponce(true,400,'You are out of range',$request->all());;
            }


            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'latitude' => 'required',
                'langitude' => 'required',
            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            $distanceInMeters = Helper::haversineGreatCircleDistance($request->latitude,$request->langitude);
            if($distanceInMeters['kilometers'] >  10){
                return  Helper::createAPIResponce(true,400,'You are out of range',$request->all());

            }

            if(User::where('email',$request->email)->first()){
              return  Helper::createAPIResponce(true,400,'Email already exist',$request->all());
            }

              $customer = $this->customer->customerSave($request,0);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'Account created successfully!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }


    public function logout(Request $request)
    {
        try {

            if(!$request->user()){
                return  Helper::createAPIResponce(true,400,'invalid access token',[]);
            }

              $authorizationHeader = $request->header('Authorization');
            if ($authorizationHeader) {
                $parts = explode(' ', $authorizationHeader);
                if (count($parts) === 2 && $parts[0] === 'Bearer') {
                      $token = $parts[1];
                }
            }

            $res=DeviceToken::where('access_token',$token)->delete();
            $request->user()->currentAccessToken()->delete();

            return  Helper::createAPIResponce(false,200,'Logged out successfully',[]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }

    public function registerBiometric(Request $request)
    {
          $request->all();



        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'fingerprint_identifie' => 'required',
            'latitude' => 'required',
            'langitude' => 'required',
        ]);

        if ($validator->fails()){
            return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
        }

        $distanceInMeters = Helper::haversineGreatCircleDistance($request->latitude,$request->langitude);
        if($distanceInMeters['kilometers'] >  10){
            return  Helper::createAPIResponce(true,400,'You are out of range',$request->all());

        }


       if(!$user = User::where('email', $request->email)->first()){
           return Helper::createAPIResponce(true,400,'Invalid email',$request->all());
       }

        $user->fingerprint_identifie=$request->fingerprint_identifie;
        $user->save();
        return Helper::createAPIResponce(false,200,'Biometric signup successfully',$request->all());
    }

    public function loginBiometric(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'fingerprint_identifie' => 'required',
            'latitude' => 'required',
            'langitude' => 'required',
        ]);

        if ($validator->fails()){
            return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
        }

        $distanceInMeters = Helper::haversineGreatCircleDistance($request->latitude,$request->langitude);
        if($distanceInMeters['kilometers'] >  10){
            return  Helper::createAPIResponce(true,400,'You are out of range',$request->all());

        }


        if (! $user = User::where('email', $request->email)->first()) {
            return  Helper::createAPIResponce(true,400,'Invalid Email',[]);
        }

        if (!$user->fingerprint_identifie === $request->fingerprint_identifie) {
            return  Helper::createAPIResponce(true,400,'Invalid fingerprint',[]);
        }

        $data['user']=$user;
        $data['accessToken']=$data['user']->createToken('auth_token')->plainTextToken;
        return  Helper::createAPIResponce(false,200,'Logged in successfully',$data);
    }

    public function updateProfile(Request $request)
    {
        try {

            $request->all();
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',

            ]);

            if ($validator->fails()){
                return  Helper::createAPIResponce(true,400,$validator->errors()->first(),$validator->errors());
            }

            if(!User::find($request->id)){
                return  Helper::createAPIResponce(true,400,'Invalid user id',$request->all());
            }

            $customer = $this->customer->customerSave($request,$request->id);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'Account updated successfully!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    //deleteProfile
    public function deleteProfile(Request $request)
    {
        try {



            if(!User::find($request->userId)){
                return  Helper::createAPIResponce(true,400,'Invalid user id',$request->all());
            }

            $customer = $this->customer->deletecustomer($request->userId);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'Account deleted successfully!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    //subsCat
    public function subsCat(Request $request)
    {
        try {


             $request->all();
            if(!$user=User::find($request->userId)){
                return  Helper::createAPIResponce(true,400,'Invalid user id',$request->all());
            }
            if(!Category::find($request->cat_id)){
                return  Helper::createAPIResponce(true,400,'Invalid cat id',$request->all());
            }


            $customer = $this->customer->subscribeUserCategory($request);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'cat subscribed!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }

    public function getUserSubscribedCategories(Request $request)
    {
        try {
            $request->all();
            if(!$user=User::find($request->userId)){
                return  Helper::createAPIResponce(true,400,'Invalid user id',$request->all());
            }
            $customer = $this->customer->getSubscribedCategory($request->userId);
            if($customer['status']){
                return  Helper::createAPIResponce(false,200,'cat subscribed!',Helper::fetchOnlyData($customer));
            }else{
                return  Helper::createAPIResponce(true,400,$customer['message'],[]);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e], 400);

        }
    }



}
