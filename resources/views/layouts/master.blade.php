
<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable"
      dir="{{(Session::get('direction'))}}">

<head>
    <meta charset="utf-8" />
    <title>Riyadah Gift</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="user_id" content="{{ auth()->user()->id }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/logo-dark.png') }}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @routes
    @include('layouts.topbar')
    @include('layouts.sidebar')



    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="text-danger mb-5">
                        {{ session('error') }}
                    </div>
                @endif


                @yield('content')



                <div id="myCustomPreLoader" >
                    <div id="status">
                        <div class="spinner-border text-primary avatar-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>


@include('layouts.customizer')

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')


<script>
    $(document).ready(function (){
        hideLoader();
        function hideLoader(){
            $('#myCustomPreLoader').css('display', 'none');
        }
    })
</script>
</body>
</html>

