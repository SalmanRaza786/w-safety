

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Riyadah Gift Card</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('layouts.web.head-css')
</head>

    @section('body')
        @include('layouts.web.body')
    @show

    <div id="layout-wrapper">
    @routes
    @include('layouts.web.topbar')
    <div class="body-wrapper">
                @if (session('error'))
                    <div class="text-danger mb-5">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')


        @include('layouts.web.footer')
    </div>
    @include('layouts.web.vendor-scripts')
    </div>
    </body>
    </html>

