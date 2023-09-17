<div>
@if ($offerData)
<style>
    .place-body {
    margin-top: -30px;
    border-radius: 15px 15px 0px 0px;
}
</style>
<div class="offer-slider py-0 mb-4" style="margin-top: -20px">
        @forelse ($offerData as $item)
        <div class="py-0"
            <a href="{{url()->current()}}/offer/{{$item->id}}">
                <div class="offer-cat-item-01" style=" background-image: url('{{app('cloudfront').$item->img}}')">
                    <div class="offer-overlay-01">
                        <h4>{{$item->translation->name}}</h4>
                    </div>
                </div>
            </a>
        </div>
        @empty
        
        @endforelse
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
@endif
</div>
@endpush