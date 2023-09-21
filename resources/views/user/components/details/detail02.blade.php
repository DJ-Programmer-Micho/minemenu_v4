<div class="container-fluid m-0 p-0">
    <div class="box2">
        <div class="box">
            <div class="top-image-container">
                <div class="icon-row">
                    <a class="back-butt-detail-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                    <a class="home-butt-detail-01" href="{{ route('business.zzz', ['business_name' => $restName])}}"><i class="fas fa-home"></i></a>
                    <livewire:cart.food-cart-counter-livewire :glang="$glang" :setting="$settings"/>
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
                    <div class="description mb-5">
                        <div class="tab">
                            <a>{{__('Description')}}</a>
                        </div>
                        <p class="text">
                            {{$foodData->translation->description}}
                        </p>
                    </div>
            <livewire:cart.food-cart-livewire :foodcartdata="$foodData" :setting="$settings" :glang="$glang"/>
            <div class="mb-5"></div>
            {{-- <div class="add-to-catr-btn">
                <button class="btn" data-toggle="modal" data-target="#addCart"> {{__('Add to Cart')}}</button>
            </div> --}}
            <x-business.copyright01component/>
        </div>
    </div>
</div>
</div>