<div>
    @if(request()->is($restName.'/cat/*'))
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{ app('cloudfront') . ($cover_id ?? $setting->background_img) }}')"></div>
    @else
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{app('cloudfront').$setting->background_img}}')"></div>
    @endif

    @if(request()->is($restName.'/*'))
    <a class="back-butt-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
    <a class="home-butt-01" href="{{ route('business.home', ['business_name' => $restName])}}"><i class="fas fa-home"></i></a>
    @endif
    <livewire:cart.food-cart-counter-livewire :glang="app()->getLocale()" :setting="$setting"/>
</div>