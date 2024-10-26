<?php
namespace App\Repositries\otp;
use App\Enums\SmsTypeEnumClass;
use App\Http\Helpers\Helper;
use App\Jobs\SendSMS;
use App\Jobs\StudentVerificationEmailJob;
use App\Models\Otp;
use App\Models\QuestionSection;
use App\Models\SignupRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\UserOtp;
use App\Notifications\OtpViaMailSmsNotification;
use DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use SMSGlobal\Credentials;
use SMSGlobal\Resource\Sms;


class OtpRepositry implements OtpInterface {



    public function sendOtp($user)
    {
      try {

           $otp= $this->generateOtp($user->id,$user->email);
           $otpText='Dear '.$user->name.
               'your verification code is :'.$otp->otp .' It will expire after 10 minutes.';

           $mailData = [
               'title' => 'OTP Verification',
               'otp' => $otp->otp,
               'body'=>$otpText,
           ];

          $user->notify(new OtpViaMailSmsNotification($mailData));

           return Helper::success([],'Otp send successfully');
         } catch (ValidationException $validationException) {
         return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
         }
    }

    public function generateOtp($userId,$email)
    {


        $updateOtp = Otp::where('email',$email)->update(['is_active' =>2]);

        $otp= Otp::create([
            'user_id' => $userId,
            'email' => $email,
            'otp' => rand(1234,9999),
            'expire_at' => now()->addMinutes(60),
            'is_active' => 1
        ]);
        return $otp;
    }

    public function getAllOtpsForAdmin($request)
    {
        try {
            $data['totalRecords'] = UserOtp::count();
            $qry = UserOtp::query();
            $qry = $qry->with('students');

            $qry=$qry->when($request->traffic_id, function ($query, $traffic_id) {
                return $query->where('mobile_no','LIKE',"%{$traffic_id}%" )->orWhere('traffic_id','LIKE',"%{$traffic_id}%" )->orWhere('email','LIKE',"%{$traffic_id}%" );
            });

            $qry=$qry->when($request->status, function ($query, $status) {
                return $query->where('is_active',$status);
            });

            $qyForCount=$qry;

            $qry=$qry->when($request->start, fn($q)=>$q->offset($request->start));
            $qry=$qry->when($request->length, fn($q)=>$q->limit($request->length));
            $data['data']=$qry->orderBy('id','DESC')->get();

            if (!empty($request->get('traffic_id')) OR !empty($request->get('status'))) {

                $qry = UserOtp::query();
                $qry=$qry->when($request->traffic_id, function ($query, $traffic_id) {
                    return $query->where('mobile_no','LIKE',"%{$traffic_id}%" )->orWhere('traffic_id','LIKE',"%{$traffic_id}%" )->orWhere('email','LIKE',"%{$traffic_id}%" );
                });

                $qry=$qry->when($request->status, function ($query, $status) {
                    return $query->where('is_active',$status);
                });
                $data['totalRecords']= $qry->count();
//                $data['totalRecords']= $qyForCount->count();
            }
            return Helper::success($data,__('translation.record_found'));

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

    public function countStdTypeWiseOtp($trafficId,$type)
    {
        try {
       $qry=UserOtp::query();
       $qry=$qry->where('traffic_id',$trafficId);
       $qry=$qry->where('sms_type',$type);
       $qry=$qry->whereDate('created_at',date('Y-m-d'));
       $data=$qry->get();
            return Helper::success($data, 'Record found');

        } catch (ValidationException $validationException) {
            return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
        } catch (\Exception $e) {
            return Helper::errorWithData($e->getMessage(),[]);
        }

    }

public function sendGenericOtp($stdId,$mailData,$smsData)
{
    return $student = Student::find($stdId);

}
public function genericOtpVerification($request)
{

    try {
        $otp=$request->digit1.$request->digit2.$request->digit3.$request->digit4;
        if(env('IS_SEND_ACTUAL_OTP')==false){

            if($otp==env('SAMPLE_OTP')){
                return Helper::success($otp, $message=__('OTP verified successfully'));
            }else{
                return Helper::error($message=__('Otp incorrect'));
            }
        }

        $validator = Validator::make($request->all(), [
            'traffic_id' => 'required|exists:user_otps,traffic_id',
        ]);

        if ($validator->fails())
            return Helper::errorWithData($validator->errors()->first(), $validator->errors());

        $userOtp   = UserOtp::where('traffic_id', $request->traffic_id)->where('otp',$otp)->where('is_active',1)->where('is_verified',0)->first();
        if (!$userOtp) {
            return Helper::error($message=__('Otp incorrect'));
        }

        $userOtp->is_verified=1;
        $userOtp->is_active=2;
        $userOtp->save();
        return Helper::success($userOtp, $message=__('OTP verified successfully'));

    } catch (ValidationException $validationException) {
        return Helper::errorWithData($validationException->errors()->first(), $validationException->errors());
    } catch (\Exception $e) {
        return Helper::errorWithData($e->getMessage(),[]);
    }
}

}
