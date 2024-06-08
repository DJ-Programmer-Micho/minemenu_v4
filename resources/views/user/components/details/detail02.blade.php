<div class="container-fluid m-0 p-0">
    <style>
        .cart-butt-detail-01,
        .rate-butt-detail-01 {
            top: 25px!important;
        }
        .badge-notification[data-count]:after {
            top: 16px!important;
        }
    </style>
    <div class="box2">
        <div class="box">
            <div class="top-image-container">
                <div class="icon-row">
                    <a class="back-butt-detail-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                    <a class="home-butt-detail-01" href="{{ route('business.zzz', ['business_name' => $restName])}}"><i class="fas fa-home"></i></a>
                    <Livewire:Cart.FoodCartCounterLivewire :glang="$glang" :setting="$settings"/>
                    @livewire('cart.food-cart-counter-livewire', ['glang' => $glang, 'setting' => $settings])
                    @livewire('rating.rest-rating-livewire', ['glang' => app()->getLocale(), 'restName' => $restName, 'setting' => $settings])

                </div>
                <div class="img-head-01">
                    <div class="content-01">
                        <img src="{{app('cloudfront').$foodData->img}}" alt="slide image" class="img-top-01">
                    </div>
                </div>
            </div>
            <div class="content-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title mb-5">{{$foodData->translation->name}}</h2>
                    </div>
                    @if($foodData->translation->description)
                    <div class="description mb-5">
                        <div class="tab">
                            <a>{{__('Description')}}</a>
                        </div>
                        <p class="text">
                            {{$foodData->translation->description}}
                        </p>
                    </div>
                    @endif
                    <div>
                        @livewire('rating.food-rating-livewire', [
                            'glang' => app()->getLocale(),
                            'avg' => number_format($foodData->food_ratings_avg_rating, 1),
                            'review' => $foodData->food_ratings_count,
                            'foodId' => $foodData->id,
                            'restName' => $restName,
                        ])
                    </div>
                    @livewire('cart.food-cart-livewire', ['foodcartdata' => $foodData, 'setting' => $settings, 'glang' => $glang])
            {{-- <Livewire:Cart.FoodCartLivewire :foodcartdata="$foodData" :setting="$settings" :glang="$glang"/> --}}
            <div class="mb-5"></div>
            {{-- <div class="add-to-catr-btn">
                <button class="btn" data-toggle="modal" data-target="#addCart"> {{__('Add to Cart')}}</button>
            </div> --}}
            <x-business.CopyRight01Component/>
        </div>
    </div>
</div>
</div>