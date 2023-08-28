<div class="offer-slider py-0 mt-1 mb-4">
    {{-- @forelse ($categoryData as $item) --}}
    <div class="py-1">
        {{-- <a href="{{url()->current()}}/offer/{{$item->id}}"> --}}
        <a href="{{url()->current()}}/offer/5">
            <div class="offer-cat-item-01" style=" background-image: url('{{app('cloudfront').'rest/menu/1red_2023230816927825282905.jpeg'}}')">
                <div class="offer-overlay-01">
                    <h4>Offer 1</h4>
                    {{-- <h4>{{$item->translation->name}}</h4> --}}
                </div>
            </div>
        </a>
    </div>
    <div class="py-1">
        {{-- <a href="{{url()->current()}}/offer/{{$item->id}}"> --}}
        <a href="{{url()->current()}}/offer/5">
            <div class="offer-cat-item-01" style=" background-image: url('{{app('cloudfront').'rest/menu/1red_2023280816932196956241.jpeg'}}')">
                <div class="offer-overlay-01">
                    <h4>Offer 4</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="py-1">
        {{-- <a href="{{url()->current()}}/offer/{{$item->id}}"> --}}
        <a href="{{url()->current()}}/offer/5">
            {{-- <div class="cat_item-01" style=" background-image: url('{{app('cloudfront').$item->img}}')"> --}}
            <div class="offer-cat-item-01" style=" background-image: url('{{app('cloudfront').'rest/menu/1red_2023230816927825805613.jpeg'}}')">
                <div class="offer-overlay-01">
                    <h4>Offer 3</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="py-1">
        {{-- <a href="{{url()->current()}}/offer/{{$item->id}}"> --}}
        <a href="{{url()->current()}}/offer/5">
            <div class="offer-cat-item-01" style=" background-image: url('{{app('cloudfront').'rest/menu/1red_202323081692781734986.jpeg'}}')">
                <div class="offer-overlay-01">
                    <h4>Offer 2</h4>
                </div>
            </div>
        </a>
    </div>
    {{-- @empty --}}
    {{-- <div class="col-12 mt-5">
        <div class="text-center">{{__('Nothing To Show')}}</div>
    </div> --}}
    {{-- @endforelse --}}
</div>

@push('business_script')   
<script>
const lang_slide = document.documentElement.getAttribute('lang');
if(lang_slide === 'ar' || lang_slide === 'ku' ){
    $('.offer-slider').slick({
                dots: true,
                rtl: true,
                centerMode: true,
                infinite: true,
                prevArrow: false,
                nextArrow: false,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }, ]
            });
} else {
    $('.offer-slider').slick({
                dots: true,
                centerMode: true,
                infinite: true,
                prevArrow: false,
                nextArrow: false,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }, ]
            });
}
 
</script>
@endpush