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
    <meta name='keywords' content='minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food'>
    <meta name="news_keywords" content="minemenu, mine menu, ماين منيو, menu iraq, menu erbil, menu resturant, qr code, resturant qr code, finedine, finedinemenu, mine menu iraq, food, drinks, food menu, menu scan, scan menu, منيو, menu generator, food menu generator, قائمة الطعام, food">
    <title>TEST MENU UI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/assets/general/lib/fontawesome-free/css/all.min.css')}}">
    <link href="{{asset('assets/general/css/toaster.css')}}" rel="stylesheet" type="text/css">

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
    @stack('business_style')
</head>
<body>
    <div class="master-container">

        <x-business.detail01component :user="$user" :detail="$detail" :ui="$ui" :settings="$setting" :settingname="$setting_name"/>

    <div class="place-footer">
        {{-- <livewire:user.components.food01-livewire/> --}}
        {{-- @include('name') --}}
    </div>
   
</div>
<script src="{{asset('/assets/general/lib/jquery/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    @livewireScripts
    
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    window.addEventListener('alert', event => { 
                 toastr[event.detail.type](event.detail.message, 
                 event.detail.title ?? ''), toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                    }
                });
    </script>
</body>
{{-- <livewire:user.ui02-livewire/> --}}
</html>