<div>
    @if(request()->is($restName.'/*'))
    <style>
        .cart-butt-detail-01 {
            top: 15px!important;
            left: 108px!important;
            right: auto!important;
        }
        .badge-notification[data-count]:after {
            top: 6px!important;
            left: 130px!important;
            right: auto!important;
        }
    </style>
    @else
    <style>
        .cart-butt-detail-01 {
            top: 15px!important;
            left: 12px!important;
            right: auto!important;
        }
        .badge-notification[data-count]:after {
            top: 6px!important;
            left: 34px!important;
            right: auto!important;
        }
    </style>
    @endif
    @if(request()->is($restName.'/cat/*'))
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{ app('cloudfront') . ($cover_id ?? $setting->background_img_header) }}')"></div>
    @else
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{app('cloudfront'). ($setting->background_img_header ?? app('fixedimage_640x360_half'))}}')"></div>
    @endif

    @if(request()->is($restName.'/*'))
    {{-- <a class="back-butt-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a> --}}
    <a class="back-butt-01" href="{{ url('/' . $restName) }}"><i class="fas fa-arrow-left"></i></a>
    <a class="home-butt-01" href="{{ route('business.zzz', ['business_name' => $restName])}}"><i class="fas fa-home"></i></a>
    @endif
    {{-- <Livewire:Cart.FoodCartCounterLivewire :glang="app()->getLocale()" :setting="$setting"/> --}}
    @livewire('cart.food-cart-counter-livewire', ['glang' => app()->getLocale(), 'setting' => $setting])

</div>