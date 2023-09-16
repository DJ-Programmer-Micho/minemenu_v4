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
    <title>{{$setting_name}} | {{__('Offers')}}</title>
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
            /* Food Detail Group */
            --food-background:  @php echo ($color->selectedFoodBackground) ?? 'red'; @endphp ;
            --food-title:  @php echo ($color->selectedFoodTitle) ?? 'red'; @endphp ;
            --food-description:  @php echo ($color->selectedFoodDescription) ?? 'red'; @endphp ;
            --food-price:  @php echo ($color->selectedFoodPrice) ?? 'red'; @endphp ;
            --food-price-key:  @php echo ($color->selectedFoodPriceKey) ?? 'red'; @endphp ;
            --food-price-value:  @php echo ($color->selectedFoodPriceValue) ?? 'red'; @endphp ;
            --food-old-price:  @php echo ($color->selectedFoodOldPrice) ?? 'red'; @endphp ;
            --food-button-text:  @php echo ($color->selectedFoodButtonText) ?? 'red'; @endphp ;
            --food-button-background:  @php echo ($color->selectedFoodButtonBackground) ?? 'red'; @endphp ;
            --food-image-shadow:  @php echo ($color->selectedFoodImageShadow) ?? 'red'; @endphp ;
            --food-image-shadow-opacity:  @php echo ($color->selectedFoodImageShadowOpacity) ?? '0.25'; @endphp ;
            /* Utilities Group */
            --utl-icon-color: @php echo ($color->selectedUtlIconColor) ?? 'blue'; @endphp ;
            --utl-icon-background: @php echo ($color->selectedUtlIconBackground) ?? 'blue'; @endphp ;
        }
    </style>
    @stack('business_style')
</head>
<body>
    <div class="master-container">

        <x-business.offerdetail01component :user="$user" :detail="$detail" :ui="$ui" :settings="$setting" :settingname="$setting_name"/>

    <div class="place-footer">

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