<!DOCTYPE html>
<html lang="{{(app()->getLocale() != 'kr') ? app()->getLocale() : 'ar'}}">
<head>
    @stack('meta_seo')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="publisher" content="MET IRAQ">
    <meta name="author" content="MINEMENU">
    <meta name="copyright" content="MINEMENU">
    <meta name="page-topic" content="Media">
    <meta name="page-type" content="website">
    <meta name="audience" content="Everyone">
    <meta name="robots" content="index, follow"> 
    <meta name='keywords' content='minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food'>
    <meta name="news_keywords" content="minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food">
    <meta name="language" content="{{app()->getLocale()}}">
    <title>{{$setting_name}} | {{__('Food')}}</title>
    {{-- PWA --}}
    <link rel="manifest" href="{{ route('generateManifest', ['business_name' => request('business_name')]) }}">
    <meta name="robots" content="index, follow">
    <meta name="HandheldFriendly" content="True"/>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{$color->selectedNavbarTop ?? '#ffffff'}}">
    <meta name="theme-color" content="{{$color->selectedNavbarTop ?? '#ffffff'}}">
    <meta name='owner' content='{{request('rest')}}'>
    <meta name='url' content='{{url()->current()}}'>
    <meta name='identifier-URL' content='{{url()->current()}}'>
    <meta property='og:title' content='{{request('business_name')}}'>
    <meta property='og:type' content='website'>
    <meta property='og:url' content={{url()->current()}}>
    <meta property='og:image' content='{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/144.png') }}'>
    <meta property='og:site_name' content='{{request('business_name')}}'>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{$color->selectedNavbarTop ?? '#ffffff'}}">
    <meta name="apple-mobile-web-app-title" content="{{request('business_name')}}">
    <link rel="apple-touch-icon" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/1024.png')}}">
    {{-- META TAGS --}}
    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="{{ $color->selectedNavbarTop ?? '#ffffff' }}">
    <meta name="msapplication-TileImage" content="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/1024.png')}}">
    <link rel="shortcut icon" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/72.png')}}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/57.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/72.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/114.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/144.png')}}">
    <link rel="apple-touch-icon" sizes="1024x1024" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/1024.png')}}"> 
    <link rel="apple-touch-startup-image" sizes="57x57" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/57.png')}}">
    <link rel="apple-touch-startup-image" sizes="72x72" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/72.png')}}">
    <link rel="apple-touch-startup-image" sizes="114x114" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/114.png')}}">
    <link rel="apple-touch-startup-image" sizes="144x144" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/144.png')}}">
    <link rel="apple-touch-startup-image" sizes="1024x1024" href="{{ app('cloudfront').$setting->background_img_avatar ?? asset('assets/general/logo/1024.png')}}"> 
    {{-- Style & JS --}}
    <script src="{{asset('/assets/general/lib/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/assets/general/lib/fontawesome-free/css/all.min.css')}}">
    <link href="{{asset('assets/general/css/toaster.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('/assets/user/master.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/header.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/sidenav.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/facility.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/detail.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/body.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/menu.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/offer.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/category.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/food.css')}}">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HGSE5M9CC"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-9HGSE5M9CC');
    </script>
    @livewireStyles
    <style>
        :root{
        /* Start */
        --start-button-text: {{ $color->selectedStartButtonText ?? '#ffffff' }};
        --start-button-background: {{ $color->selectedStartButtonBackground ?? '#cc0022' }};
        --start-opacity: {{ $color->selectedStartOpacity ?? '0.3' }};
        /* Navbar */
        --navbar-title-color: {{ $color->selectedNavbarTitle ?? '#cc0022' }};
        --navbar-toggle-color: {{ $color->selectedNavbarToggle ?? '#000000' }};
        --navbar-top-color: {{ $color->selectedNavbarTop ?? '#ffffff' }};
        --navbar-sub-title-color: {{ $color->selectedNavbarSubTitle ?? '#b97e87' }};
        --navbar-text-color: {{ $color->selectedNavbarText ?? '#766fa8' }};
        --navbar-top-ground-color: {{ $color->selectedNavbarTopGround ?? '#766fa8' }};
        --navbar-bottom-ground-color: {{ $color->selectedNavbarBottomGround ?? '#766fa8' }};
        /* Main Group */
        --main-background-color: {{ $color->selectedMainBackground ?? '#ffffff' }};
        --main-body-color: {{ $color->selectedMainBody ?? '#b8b8b8' }};
        --main-theme-text-color: {{ $color->selectedMainThemeText ?? '#cc0022' }};
        --main-theme-background-color: {{ $color->selectedMainThemeBackgroud ?? '#ffffff' }};
        --main-theme-text-active-color: {{ $color->selectedMainThemeTextActive ?? '#cc0022' }};
        --main-theme-background-active-color: {{ $color->selectedMainThemeBackgroundActive ?? '#ffffff' }};
        --main-theme-border-active-color: {{ $color->selectedMainThemeBorder ?? '#cc0022' }};
        --main-card-text-color: {{ $color->selectedMainCardText ?? '#ffffff' }};
        --main-card-opacity-color: {{ $color->selectedMainCardOpacity ?? '0.3' }};
        /* Cart Group */
        --cart-icon-color: {{ $color->selectedCartIcon ?? '#ffffff' }};
        --cart-back-icon-color: {{ $color->selectedCartBackIcon ?? '#333234' }};
        --cart-noti-color: {{ $color->selectedCartNoti ?? '#ffffff' }};
        --cart-back-noti-color: {{ $color->selectedCartBackNoti ?? '#cc0022' }};
        --cart-text-color: {{ $color->selectedCartText ?? '#000000' }};
        --cart-background-color: {{ $color->selectedCartBackground ?? '#ffffff' }};
        --cart-reset-text-color: {{ $color->selectedCartResetText ?? '#ffffff' }};
        --cart-reset-backgound-color: {{ $color->selectedCartResetBackgound ?? '#cc0022' }};
        --cart-close-text-color: {{ $color->selectedCartCloseText ?? '#ffffff' }};
        --cart-close-backgound-color: {{ $color->selectedCartCloseBackgound ?? '#cc0022' }};
        /* Category Group */
        --category-title-color: {{ $color->selectedCategoryTitle ?? '#cc0022' }};
        --category-description-color: {{ $color->selectedCategoryDescription ?? '#000000' }};
        --category-price-color: {{ $color->selectedCategoryPrice ?? '#000000' }};
        --category-old-price-color: {{ $color->selectedCategoryOldPrice ?? '#cc0022' }};
        --category-card-background-color: {{ $color->selectedCategoryCardBackground ?? '#ffffff' }};
        --category-shadow-color: {{ $color->selectedCategoryShabow ?? '#dedede' }};
        --category-button-text-color: {{ $color->selectedCategoryButtonText ?? '#ffffff' }};
        --category-button-background-color: {{ $color->selectedCategoryButtonBackground ?? '#cc0022' }};
        /* Food Detail Group */
        --food-background:  {{ ($color->selectedFoodBackground) ?? '#ffffff'}};
        --food-title:  {{ ($color->selectedFoodTitle) ?? '#cc0022'}};
        --food-description:  {{ ($color->selectedFoodDescription) ?? '#000000'}};
        --food-price:  {{ ($color->selectedFoodPrice) ?? '#000000'}};
        --food-price-key:  {{ ($color->selectedFoodPriceKey) ?? '#cc0022'}};
        --food-price-value:  {{ ($color->selectedFoodPriceValue) ?? '#000000'}};
        --food-old-price:  {{ ($color->selectedFoodOldPrice) ?? '#000000'}};
        --food-button-text:  {{ ($color->selectedFoodButtonText) ?? '#ffffff'}};
        --food-button-background:  {{ ($color->selectedFoodButtonBackground) ?? '#cc0022'}};
        --food-image-shadow:  {{ ($color->selectedFoodImageShadow) ?? '#cc0022'}};
        --food-image-shadow-opacity:  {{ ($color->selectedFoodImageShadowOpacity) ?? '0.1'}};
        /* Utilities Group */
        --utl-icon-color: {{ $color->selectedUtlIconColor ?? '#ffffff' }};
        --utl-icon-background: {{ $color->selectedUtlIconBackground ?? '#323334' }};
        }
    </style>
    @stack('business_style')
</head>
<body>
    <div class="master-container">
        <x-business.Detail01Component :user="$user" :detail="$detail" :ui="$ui" :settings="$setting" :settingname="$setting_name"/>
    <div class="place-footer">

    </div>
   
</div>
<script src="{{asset('/assets/general/lib/jquery/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
 

<form id="languageForm" action="{{ route('setLocale') }}" method="post">
    @csrf
    <input type="hidden" name="locale" id="selectedLocale" value="{{ app()->getLocale() }}">
</form>
<script>
    // Function to change the language and submit the form
    function changeLanguage(locale) {
        document.getElementById('selectedLocale').value = locale;
        document.getElementById('languageForm').submit();
    }
</script>
<script type="text/javascript" src="{{asset('/assets/general/lib/js/toaster.js')}}"></script>
<script>
    window.addEventListener('alert', event => { 
                 toastr[event.detail.type](event.detail.message, 
                 event.detail.title ?? ''), toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "hideDuration": 100,
                    }
                });
    </script>
       @livewireScripts
       @stack('business_script')
</body>
</html>