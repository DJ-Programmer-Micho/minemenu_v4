<div>
    
    {{-- <div class="place-header-inner" id="rest-img" style="background-image: url('{{$cloudFront .'/'. ((isset($catPic) && $catPic !=null) ? $catPic : $user_ui->logo)}}')"></div> --}}
    <div class="place-header-inner" id="rest-img" style="background-image: url('{{app('cloudfront').'rest/menu/1red_2023160816922125980618.jpeg'}}')"></div>
    {{-- @section('back') --}}
    <a class="home-butt" href="">asd<i class="fa-solid fa-house"></i></a> 
    <a class="back-butt" href="">asd<i class="fa-solid fa-arrow-left"></i></a>
{{-- @endsection --}}

    <div id="my-cart">
        {{-- @include('main.index.layouts.cart') --}}
    </div>

</div>