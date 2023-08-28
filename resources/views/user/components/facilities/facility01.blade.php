{{-- <div class="title-lang-01 d-flex justify-content-between">
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
    @if (!empty($setting->address))
    <div class="col-md-12 mb-3">
        <span><i class="fas fa-map-marker-alt"></i> {{ $setting->address }} Erbil, Dream City</span>
    </div>
    @endif

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
</div> --}}
<div class="header">
    <h3 class="text-center mt-3">{{$setting_name}}<h1>
</div>
    <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
    <label for="openSidebarMenu" class="sidebarIconToggle">
      <div class="spinner diagonal part-1"></div>
      <div class="spinner horizontal"></div>
      <div class="spinner diagonal part-2"></div>
    </label>
    <div id="sidebarMenu">
      <ul class="sidebarMenuInner">
        <li>{{$setting_name}}</li>
        @foreach ($filteredLocales as $locale)
        <li><a href="#"  onclick="changeLanguage('{{ $locale }}')">{{ __(strtoupper($locale)) }}</a></li>
        @endforeach
        @if (!empty($setting->wifi))
        <li><a href="#"  onclick="copyWifiPassword()"><i class="fa fa-wifi"></i> {{ $setting->wifi }}</a></li>
        @endif
        @if (!empty($setting->phone))
        <li><a class="phone-number-01"><i class="fas fa-mobile"></i> <a href="{{ 'tel:' . $setting->phone }}" class="phone-link-01">{{ $setting->phone }}</a></a></li>
        @endif
      </ul>
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