

<div class="container-fluid m-0 p-0">
    <div class="box2">
        <div class="box">
            <div class="top-image-container">
                <div class="icon-row">
                    <a class="back-butt-detail-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                    <a class="home-butt-detail-01" href="{{ route('business.home', ['business_name' => 'red'])}}"><i class="fas fa-home"></i></a>
                    <livewire:cart.food-cart-counter-livewire :glang="$glang" :setting="$settings"/>
                </div>
                <div class="img-head-01">
                    <div class="content-01">
                        <img src="{{app('cloudfront').$offerData->img}}" alt="slide image" class="img-top-01">
                    </div>
                </div>
            </div>
            <div class="content-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title mb-5">{{$offerData->translation->name}}</h2>
                    </div>
            <livewire:cart.offer-cart-livewire :offercartdata="$offerData" :setting="$settings" :glang="$glang"/>
            <div class="description mt-5">
                <div class="tab">
                    <a>Description</a>
                </div>
                <p class="text">
                    {{$offerData->translation->description}}
                </p>
            </div>
            
            {{-- <div class="add-to-catr-btn">
                <button class="btn" data-toggle="modal" data-target="#addCart"> {{__('Add to Cart')}}</button>
            </div> --}}
        </div>
    </div>
</div>
</div>