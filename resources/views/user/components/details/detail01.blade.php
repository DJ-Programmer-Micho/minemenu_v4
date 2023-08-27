<div class="place-header">

    {{-- <div class="place-header-inner" id="rest-img" style="background-image: url('{{$cloudFront .'/'. ((isset($catPic) && $catPic !=null) ? $catPic : $user_ui->logo)}}')">
</div> --}}
<div class="place-header-inner" id="rest-img" style="background-image: url('{{app('cloudfront').$foodData->img}}')">
</div>
{{-- @section('back') --}}
<a class="back-butt" href="">zxc<i class="fa-solid fa-arrow-left"></i></a>
<a class="home-butt" href="">zxc<i class="fa-solid fa-house"></i></a>
{{-- @endsection --}}

<div id="my-cart">
    {{-- @include('main.index.layouts.cart') --}}
</div>
</div>
<div class="place-body">
    <div class="d-flex justify-content-between title-lang">
        <h4 id="rest-title">{{$setting_name}}</h4>
        <select name="my_select" class="mySelect" onchange="selectLang(this.value);" id="list" name="list">

            <option>{{__("Language")}}</option>
            <option value="kr">كوردى</option>
            <option value="ar">العربية</option>
            <option value="en">asd</option>
        </select>
        @foreach ($filteredLocales as $locale)
        <a class="dropdown-item" href="#" onclick="changeLanguage('{{ $locale }}')">
            <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
            {{ strtoupper($locale) }}
        </a>
        @endforeach
    </div>

    <h1 class="text-white">{{$foodData->translation->name}}</h1>
    <p class="text-white">{{$foodData->translation->description}}</p>
    <p class="text-white">{{$foodData->price}}</p>
    <p class="text-white">{{$foodData->old_price}}</p>
    <div>

        {{-- <livewire:user.components.body01-livewire :user="$data" :setting="$setting"/> --}}
    </div>
</div>