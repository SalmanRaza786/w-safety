<?php

namespace App\Repositries\otp;

interface OtpInterface
{

    public function sendOtp($user);
    public function getAllOtpsForAdmin($request);
    public function countStdTypeWiseOtp($trafficId,$type);
    public function sendGenericOtp($stdId,$mailData,$smsData);
    public function generateOtp($userId,$email);
    public function genericOtpVerification($request);



}
