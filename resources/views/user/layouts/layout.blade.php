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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="{{asset('/assets/general/lib/fontawesome-free/css/all.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('/assets/user/ui-01/style.css')}}"> --}}
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
    @livewireStyles
    <style>
        :root{
            /* Navbar */
            --navbar-title-color: @php echo ($color->selectedNavbarTitle) ?? 'blue'; @endphp ;
            --navbar-toggle-color: @php echo ($color->selectedNavbarToggle) ?? 'blue'; @endphp ;
            --navbar-top-color: @php echo ($color->selectedNavbarTop) ?? 'blue'; @endphp ;
            --navbar-sub-title-color: @php echo ($color->selectedNavbarSubTitle) ?? 'blue'; @endphp ;
            --navbar-text-color: @php echo ($color->selectedNavbarText) ?? 'blue'; @endphp ;
            --navbar-top-ground-color: @php echo ($color->selectedNavbarTopGround) ?? 'blue'; @endphp ;
            --navbar-bottom-ground-color: @php echo ($color->selectedNavbarBottomGround) ?? 'blue'; @endphp ;
            /* Main Group */
            --main-background-color: @php echo ($color->selectedMainBackground) ?? 'blue'; @endphp ;
            --main-body-color: @php echo ($color->selectedMainBody) ?? 'blue'; @endphp ;
            --main-theme-text-color: @php echo ($color->selectedMainThemeText) ?? 'blue'; @endphp ;
            --main-theme-backgroud-color: @php echo ($color->selectedMainThemeBackgroud) ?? 'blue'; @endphp ;
            --main-theme-text-active-color: @php echo ($color->selectedMainThemeTextActive) ?? 'blue'; @endphp ;
            --main-theme-background-active-color: @php echo ($color->selectedMainThemeBackgroudActive) ?? 'blue'; @endphp ;
            --main-theme-border-active-color: @php echo ($color->selectedMainThemeBorder) ?? 'blue'; @endphp ;
            --main-card-text-color: @php echo ($color->selectedMainCardText) ?? 'blue'; @endphp ;
            --main-card-opacity-color: @php echo ($color->selectedMainCardOpacity) ?? 'blue'; @endphp ;
            /* Cart Group */
            --cart-icon-color: @php echo ($color->selectedCartIcon) ?? 'blue'; @endphp ;
            --cart-back-icon-color: @php echo ($color->selectedCartBackIcon) ?? 'blue'; @endphp ;
            --cart-noti-color: @php echo ($color->selectedCartNoti) ?? 'blue'; @endphp ;
            --cart-back-noti-color: @php echo ($color->selectedCartBackNoti) ?? 'blue'; @endphp ;
            --cart-text-color: @php echo ($color->selectedCartText) ?? 'blue'; @endphp ;
            --cart-background-color: @php echo ($color->selectedCartBackground) ?? 'blue'; @endphp ;
            --cart-reset-text-color: @php echo ($color->selectedCartResetText) ?? 'blue'; @endphp ;
            --cart-reset-backgound-color: @php echo ($color->selectedCartResetBackgound) ?? 'blue'; @endphp ;
            --cart-close-text-color: @php echo ($color->selectedCartCloseText) ?? 'blue'; @endphp ;
            --cart-close-backgound-color : @php echo ($color->selectedCartCloseBackgound) ?? 'blue'; @endphp ;
            /* Category Group */
            --category-title-color: @php echo ($color->selectedCategoryTitle) ?? 'red'; @endphp ;
            --category-description-color: @php echo ($color->selectedCategoryDescription) ?? 'blue'; @endphp ;
            --category-price-color: @php echo ($color->selectedCategoryPrice) ?? 'blue'; @endphp ;
            --category-old-price-color: @php echo ($color->selectedCategoryOldPrice) ?? 'blue'; @endphp ;
            --category-card-background-color: @php echo ($color->selectedCategoryCardBackground) ?? 'blue'; @endphp ;
            --category-shadow-color: @php echo ($color->selectedCategoryShabow) ?? 'blue'; @endphp ;
            --category-button-text-color: @php echo ($color->selectedCategoryButtonText) ?? 'blue'; @endphp ;
            --category-button-background-color: @php echo ($color->selectedCategoryButtonBackground) ?? 'blue'; @endphp ;
            /* Utilities Group */
            --utl-icon-color: @php echo ($color->selectedUtlIconColor) ?? 'blue'; @endphp ;
            --utl-icon-background: @php echo ($color->selectedUtlIconBackground) ?? 'blue'; @endphp ;
            
        }
    </style>

    @stack('business_style')
</head>
<body>
<div class="master-container">

    {{-- @if (count(request()->segments()) <= 3) --}}
    <x-business.Facilities01Component :settingname="$setting_name" :settingaddress="$setting_address" :setting="$setting" :filteredlocales="$filteredLocales" :ui="$ui"/>
    {{-- @endif --}}
    <div class="place-header">
        <x-business.header01component :user="$user" :ui="$ui" :setting="$setting" :coverid="$cover_id ?? null"/>
    </div>
    <div class="place-body">
        @yield('business-content')
    </div>
    <div class="place-footer"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<form id="languageForm" action="{{ route('setLocale') }}" method="post">
    @csrf
    <input type="hidden" name="locale" id="selectedLocale" value="{{ app()->getLocale() }}">
</form>
<script>
    function changeLanguage(locale) {
        document.getElementById('selectedLocale').value = locale;
        document.getElementById('languageForm').submit();
    }
</script>
@livewireScripts
@stack('business_script')
</body>
</html>