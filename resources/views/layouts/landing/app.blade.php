<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title')</title>
    <meta name="_token" content="{{csrf_token()}}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="shortcut icon"
          href="{{asset('storage/app/public/favicon')}}/{{Helpers::get_business_settings('favicon') ?? null}}"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{asset('public/assets/landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/landing/css/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/icon-set/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/landing/plugins/swiper/swiper-bundle.min.css')}}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('public/assets/landing/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/landing/css/custom.css')}}">

    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">

    @stack('css_or_js')
</head>

<body>
<div class="preloader">
    <div class="spinner-grow" role="status">
        <span class="visually-hidden">{{translate('Loading')}}...</span>
    </div>
</div>

{{-- @include('layouts.landing.partials._header') --}}

<main class="main-content d-flex flex-column">
    @yield('content')
</main>

    {{-- @include('layouts.landing.partials._footer') --}}
</section>

<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>


<script src="{{asset('public/assets/landing/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('public/assets/landing/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/assets/landing/plugins/swiper/swiper-bundle.min.js')}}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{asset('public/assets/landing/js/main.js')}}"></script>

<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>

@stack('script_2')

<script>
    $(document).on('ready', function () {
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        $('.js-validate').each(function () {
            $.HSCore.components.HSValidation.init($(this));
        });
    });
</script>


<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
</body>
</html>
