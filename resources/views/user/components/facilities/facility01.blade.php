<div class="title-lang-01 d-flex justify-content-between">
    <h4 id="rest-title">{{$setting_name}}</h4>
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
<div class="facilities-01 row">
    {{-- @if (!empty($setting->address)) --}}
    <div class="col-md-12 mb-3">
        <span><i class="fas fa-map-marker-alt"></i> {{ $setting->address }} Erbil, Dream City</span>
    </div>
    {{-- @endif --}}

    @if (!empty($setting->wifi))
    <div class="col-6 mb-3">
        <span id="wifiPassword" class="wifi-password-01" onclick="copyWifiPassword()">
            <i class="fa fa-wifi"></i> {{ $setting->wifi }}
        </span>
    </div>
    @endif

    @if (!empty($setting->phone))
    <div class="col-6 mb-3">
        <span class="phone-number-01"><i class="fas fa-mobile"></i> <a href="{{ 'tel:' . $setting->phone }}" class="phone-link-01">{{ $setting->phone }}</a></span>
    </div>
    @endif
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