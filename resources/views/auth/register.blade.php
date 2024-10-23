

@extends('layouts.web.master')
@section('title') @lang('translation.roles') @endsection
@section('content')


    <div class="body-wrapper">


        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active"> Register</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-section mb-60">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xs-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form action="{{route('register')}}" method="post">
                            @csrf
                            <div class="login-form">
                                <h4 class="login-title">Register</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-20">
                                        <label> Name</label>
                                        <input class="mb-0" type="text" placeholder="Name" name="name">
                                    </div>
                                    <div class="col-md-12 mb-20">
                                        <label>Email*</label>
                                        <input class="mb-0" type="email" placeholder="Email Address" name="email">
                                    </div>
                                    <div class="col-md-12 mb-20">
                                        <label>Phone*</label>
                                        <input class="mb-0" type="tel" placeholder="Phone" name="phone" id="tel">
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label>Password</label>
                                        <input class="mb-0" type="password" placeholder="Password" name="password">
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label>Confirm Password</label>
                                        <input class="mb-0" type="password" placeholder="Confirm Password" name="password_confirmation">
                                    </div>
                                    <div class="col-md-12 mb-20">
                                        <label>Address</label>
                                        <textarea name="address" id="" cols="10" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="register-button mt-0" type="submit">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>


@endsection




