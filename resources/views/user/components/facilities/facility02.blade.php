<div class="facilities-02">
<div class="title-lang-02 d-flex justify-content-between">
    <h4 id="rest-title-02">{{$setting_name}}</h4>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{-- <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i> --}}
            <img src="{{asset('/assets/general/flags/'.app()->getLocale().'.png')}}" width="20" alt="minemenu">
            {{ __(strtoupper(app()->getLocale())) }}
        </button>
        <div class="dropdown-menu" aria-labelledby="languageDropdown">
            @foreach ($filteredLocales as $locale)
                <a class="dropdown-item" href="#" onclick="changeLanguage('{{ $locale }}')">
                    <img src="{{asset('/assets/general/flags/'.$locale.'.png')}}" width="20" alt="minemenu"> {{ __(strtoupper($locale)) }}
                </a>
            @endforeach
        </div>
    </div>
</div>
    <div class="d-flex justify-content-between info-02">
    @if (!empty($setting->wifi))
        @if ($locale == 'ar' || $locale == 'ku')
        <div><a href="{{$setting->map}}"  target="_blank" style="text-transform: none;"><i class="fas fa-location-arrow"></i> {{ $setting_address }}</a></div>
        @else
        <div><a href="{{$setting->map}}"  target="_blank" style="text-transform: none;"><i class="fas fa-location-arrow"></i> {{ $setting_address }}</a></div>
        @endif
    @endif
    @if (!empty($setting->wifi))
    <div><a href="#"  onclick="copyWifiPassword()" style="text-transform: none;"><i class="fa fa-wifi"></i> {{ $setting->wifi }}</a></div>
    @endif
    @if (!empty($setting->phone))
    <div><a class="phone-number-01"  href="{{ 'tel:' . $setting->phone }}" dir="ltr"><i class="fas fa-mobile"></i>{{ $setting->phone }}</a></div>
    @endif
    </div>
</div>

<script>
    function copyWifiPassword() {
        var wifiPassword = "{{ $setting->wifi }}";
        var tempInput = document.createElement("input");
        tempInput.value = wifiPassword;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Wi-Fi password copied: " + wifiPassword);
    }
</script>