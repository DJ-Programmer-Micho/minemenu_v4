<!DOCTYPE html>
<html lang="{{(app()->getLocale() != 'kr') ? app()->getLocale() : 'ar'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="publisher" content="Michel Shabo">
    {{-- <meta name="mobile-web-app-title" content="{{request('rest')}}"> --}}
    <meta name="author" content="MET iraq">
    <meta name="copyright" content="MET Iraq">
    <meta name="page-topic" content="Media">
    <meta name="page-type" content="website">
    <meta name="audience" content="Everyone">
    <meta name="robots" content="index, follow"> 
    <script src="{{asset('/assets/general/lib/jquery/jquery.min.js')}}"></script>
    {{-- PWA --}}
    {{-- <meta name="HandheldFriendly" content="True"/>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{ ($user_ui->theme_color) ?: 'orange'}}">
    <meta name="theme-color" content="{{ ($user_ui->theme_color) ?: 'orange'}}">
    <meta name='owner' content='{{request('rest')}}'>
    <meta name='url' content='{{url()->current()}}'>
    <meta name='identifier-URL' content='{{url()->current()}}'>
    <meta name='og:title' content='{{request('rest')}}'>
    <meta name='og:type' content='website'>
    <meta name='og:url' content={{url()->current()}}>
    <meta name='og:image' content='assets/main/img/main/Head1.png'>
    <meta name='og:site_name' content='{{request('rest')}}'>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{($user_ui->theme_color) ?: 'orange'}}">
    <meta name="apple-mobile-web-app-title" content="{{request('rest')}}">
    <link rel="apple-touch-icon" href="/assets/main/img/logo/1024.png"> --}}
    <!-- Tile for Win8 -->
    {{-- <meta name="msapplication-TileColor" content="{{($user_ui->theme_color) ?: 'white'}}">
    <meta name="msapplication-TileImage" content="/assets/main/img/logo/1024.png">
    <link rel="shortcut icon" href="/assets/main/img/logo/72.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/main/img/logo/57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/main/img/logo/72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/main/img/logo/114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/main/img/logo/144.png">
    <link rel="apple-touch-icon" sizes="1000x1000" href="/assets/main/img/logo/logo.png">
    <link rel="apple-touch-icon" sizes="1024x1024" href="/assets/main/img/logo/1024.png"> --}}
    {{-- META TAGS --}}
    <meta name='keywords' content='minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food'>
    <meta name="news_keywords" content="minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food">
    <title>Mine Menu | {{$setting_name}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{asset('/assets/general/lib/fontawesome-free/css/all.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('/assets/user/ui-01/style.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('/assets/user/master.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/header.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/sidenav.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/facility.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/body.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/menu.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/offer.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/category.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/user/food.css')}}">
    {{-- @livewireStyles --}}
    @stack('business_style')
</head>
<body>
<div class="master-container">

    <x-business.Facilities01Component :settingname="$setting_name" :setting="$setting" :filteredlocales="$filteredLocales" :ui="$ui"/>

    <div class="place-header">
        {{-- @include('name') --}}
        <x-business.header01component :user="$user" :ui="$ui"/>
        {{-- <livewire:user.components.header01-livewire :data="$data"/> --}}
    </div>

    <div class="place-body">
      
        @yield('business-content')
    </div>

    
    <div class="place-footer"></div>
   
</div>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    {{-- @livewireScripts --}}
    
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
@stack('business_script')

</body>
{{-- <livewire:user.ui02-livewire/> --}}
</html>