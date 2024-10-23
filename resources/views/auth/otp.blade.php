

@extends('layouts.web.master')
@section('title') @lang('translation.roles') @endsection
@section('content')


    <link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />



                    <div class="row">
                        <div class="col-lg-12">


                            <div class="card overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-lg-6">




                                    <div class="col-lg-6">
                                        <div class="p-lg-5 p-4">

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="p-2 mt-4">
                                                <div class="text-muted text-center mb-4 mx-lg-3">

                                                    @if ($message = Session::get('error'))
                                                        <span class=" text-center text-danger"> {{ $message }}</span>
                                                    @endif
                                                    <h4>{{__('translation.Verify_OTP')}}</h4>
{{--                                                    <p>{{__('translation.enter_otp_code')}}<span class="fw-semibold">{{ $maskedPhoneNumber = str_repeat("*", strlen($data['student']->otp) - 4) . substr($data['student']->mobile_no, -4)}}</span></p>--}}

                                                    <p><span class="fw-semibold">{{ \App\Http\Helpers\Helper::maskEmail($data['student']->email)}}</span></p>

                                                </div>


                                                <form autocomplete="off" method="post" action="{{route('otp.verify',['locale'=>\Illuminate\Support\Facades\App::currentLocale()])}}" id="OtpForm">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-3">
                                                            <div class="mb-3">
                                                                <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                                <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(1, event)" maxlength="1" id="digit1-input" name="digit1" required>
                                                            </div>
                                                        </div><!-- end col -->

                                                        <div class="col-3">
                                                            <div class="mb-3">
                                                                <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                                <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(2, event)" maxlength="1" id="digit2-input" name="digit2" required>
                                                            </div>
                                                        </div><!-- end col -->

                                                        <div class="col-3">
                                                            <div class="mb-3">
                                                                <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                                <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(3, event)" maxlength="1" id="digit3-input" name="digit3" required>
                                                            </div>
                                                        </div><!-- end col -->

                                                        <div class="col-3">
                                                            <div class="mb-3">
                                                                <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                                <input type="text" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(4, event)" maxlength="1" id="digit4-input" name="digit4" required>
                                                            </div>
                                                        </div><!-- end col -->

                                                        <div class="mt-3">
                                                            <button type="submit" class="btn btn-success w-100 btn-confirm">Confirm</button>
                                                        </div>
                                                    </div>
                                                </form><!-- end form -->

                                            </div>

{{--                                            <div class="mt-5 text-center">--}}
{{--                                                <form action="{{ route('otp.resend',['locale'=>'en']) }}" method="post" id="ResendForm">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="traffic_id" value="{{$data['trafficId']}}">--}}
{{--                                                    <input type="hidden" name="type" value="{{$data['type']}}">--}}
{{--                                                    --}}{{--                                                @if($data['totalOtps']->count()<3)--}}
{{--                                                    <p class="mb-0 resend-section">Didn't receive a code ?--}}
{{--                                                        <button type="submit"  class="btn btn-ghost-primary waves-effect waves-light" id="sendOTP" > Resend</button>--}}
{{--                                                    </p>--}}
{{--                                                    --}}{{--                                                @endif--}}
{{--                                                </form>--}}
{{--                                                <div class="resend-section" id="timer" style="color: red"></div>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                    </div>



        <script src="{{ URL::asset('build/js/pages/two-step-verification.init.js') }}"></script>
        <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>

        <script>
            var otpCounter=0;
            var otpTimer;
            var otpTimeout = 60; // Set the OTP timeout in seconds

            function startOTPTimer() {
                var timerDisplay = document.getElementById("timer");
                var sendOTPButton = document.getElementById("sendOTP");
                var otpTimestamp = document.getElementById("otpTimestamp");

                var currentTime = otpTimeout;
                timerDisplay.innerHTML = "Resend OTP in " + currentTime + " seconds";

                otpTimer = setInterval(function () {
                    currentTime--;
                    if (currentTime <= 0) {
                        clearInterval(otpTimer);
                        sendOTPButton.disabled = false;
                        timerDisplay.innerHTML = "";
                    } else {
                        timerDisplay.innerHTML = "Resend OTP in " + currentTime + " seconds";
                    }
                }, 1000);

                // Store the OTP creation timestamp
                var currentTimestamp = Math.floor(Date.now() / 1000); // Unix timestamp in seconds
                otpTimestamp.value = currentTimestamp;
                sendOTPButton.disabled = true;
            }
            // Attach the timer function to the "Send OTP" button
            document.getElementById("sendOTP").addEventListener("click", startOTPTimer);

            $('#ResendForm').on('submit', function(e) {
                e.preventDefault();


                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {

                        $("#sendOTP").prop("disabled", true);
                    },
                    success: function(response) {

                        if(response.status){
                            toastr.success(response.message);
                            otpCounter=otpCounter+1;
                            fnOtpCounter(otpCounter);
                        }
                        if(!response.status){
                            $('.resend-section').css('display','none');
                            toastr.error(response.message);
                        }
                    },

                    complete: function(data) {
                        // $("#sendOTP").prop("disabled", false);
                    },

                    error: function(xhr, status, error) {
                        if(xhr.responseText){
                            toastr.error(xhr.responseText);
                        }
                        if(xhr.responseJSON.message){
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });

            function fnOtpCounter(otpCount){
                if(otpCount >=3){

                    $('.resend-section').css('display','none');
                }
            }

            //OtpForm
            $("#OtpForm").submit(function (event) {
                event.preventDefault();
                if (customValidation()) {
                    $(".btn-confirm").prop("disabled", true);
                    $(".btn-confirm").html("loading...");
                    this.submit();
                } else {
                    alert("Form validation failed. Please check your input.");
                }
            });

            function customValidation() {

                if ($("input[name=digit1]").val().length < 0) {
                    return false;
                }

                if ($("input[name=digit2]").val().length < 0) {
                    return false;
                }

                if ($("input[name=digit3]").val().length < 0) {
                    return false;
                }

                if ($("input[name=digit4]").val().length < 0) {
                    return false;
                }

                return true;
            }

        </script>


    @endsection





