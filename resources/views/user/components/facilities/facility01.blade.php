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
        <li class="sub_title" style="direction: rtl; text-align: right;">
            <h5>{{$setting_name}}</h5>
            <p>{{__('top #100 resturant')}}</p>
        </li>

        @foreach ($filteredLocales as $locale)
        @if ($locale == 'ar' || $locale == 'ku')
        {{-- <li style="direction: rtl; text-align: right;"><a href="#"  onclick="changeLanguage('{{ $locale }}')"><i class="fas fa-language"></i> {{ __(strtoupper($locale)) }}</a></li> --}}
        <li style="direction: rtl; text-align: right;"><a href="#"  onclick="changeLanguage('{{ $locale }}')"><img src="{{asset('/assets/general/flags/'.$locale.'.png')}}" width="20" alt="minemenu"> {{ __(strtoupper($locale)) }}</a></li>
        @else
        {{-- <li><a href="#"  onclick="changeLanguage('{{ $locale }}')"><i class="fas fa-language"></i> {{ __(strtoupper($locale)) }}</a></li> --}}
        <li style="direction: ltr; text-align: left;"><a href="#"  onclick="changeLanguage('{{ $locale }}')"><img src="{{asset('/assets/general/flags/'.$locale.'.png')}}" width="20" alt="minemenu"> {{ __(strtoupper($locale)) }}</a></li>
        @endif
        @endforeach
        @if (!empty($setting->wifi))
        <li><a href="{{$setting->map}}"  target="_blank" style="text-transform: none;"><i class="fas fa-location-arrow"></i> {{ $setting_address }}</a></li>
        @endif
        @if (!empty($setting->wifi))
        <li><a href="#"  onclick="copyWifiPassword()" style="text-transform: none;"><i class="fa fa-wifi"></i> {{ $setting->wifi }}</a></li>
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