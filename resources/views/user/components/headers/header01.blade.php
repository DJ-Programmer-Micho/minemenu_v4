<div>
    <div class="place-header-inner-01" id="rest-img" style="background-image: url('{{app('cloudfront').'rest/menu/1red_2023160816922125980618.jpeg'}}')"></div>
    @if(request()->is('red/*'))
    <a class="back-butt-01" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
    <a class="home-butt-01" href="{{ route('business.home', ['business_name' => 'red'])}}"><i class="fas fa-home"></i></a>
    @endif
    <div class="language-but">
        {{-- @include('main.index.layouts.cart') --}}
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __(strtoupper($selectedLocale)) }}
            </button>
            <div class="dropdown-menu" aria-labelledby="languageDropdown">
                @foreach ($filteredLocales as $locale)
                    <a class="dropdown-item" href="#" onclick="changeLanguage('{{ $locale }}')">
                        {{ __(strtoupper($locale)) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>