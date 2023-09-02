<div>
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{app('cloudfront').'rest/menu/1red_2023160816922125980618.jpeg'}}')"></div>
    @if(request()->is('red/*'))
    <a class="back-butt-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
    <a class="home-butt-01" href="{{ route('business.home', ['business_name' => 'red'])}}"><i class="fas fa-home"></i></a>
    @endif
    <livewire:cart.food-cart-counter-livewire :glang="app()->getLocale()" :setting="$setting"/>
</div>