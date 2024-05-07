<div class="facilities-03 fixed-bottom mx-auto" style="max-width: 800px">
    <div class="title-lang-02 d-flex justify-content-between">
        <h4 id="rest-title-02">{{$setting_name}}</h4>
        <div class="toggle-icon-03">
            <i class="fas fa-chevron-up"></i>
        </div>
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
    <div class="info-02">
        <div class="row">
            <div class="col-md-3 col-6 order-1 order-md-1">
                @if (!empty($setting_address))
                    @if ($locale == 'ar' || $locale == 'ku')
                        <div><a href="{{$setting->map}}" target="_blank" style="text-transform: none;"><i class="fas fa-location-arrow"></i> {{ $setting_address }}</a></div>
                    @else
                        <div><a href="{{$setting->map}}" target="_blank" style="text-transform: none;"><i class="fas fa-location-arrow"></i> {{ $setting_address }}</a></div>
                    @endif
                @endif
            </div>
            <div class="col-md-3 col-6 order-3 order-md-2">
                @if (!empty($setting->wifi))
                    <div><a href="#" onclick="copyWifiPassword()" style="text-transform: none;"><i class="fa fa-wifi"></i> {{ $setting->wifi }}</a></div>
                @endif
            </div>
            <div class="col-md-3 col-6 order-2 order-md-3">
                @if (!empty($setting->phone))
                    <div><a class="phone-number-01" href="{{ 'tel:' . $setting->phone }}" dir="ltr"><i class="fas fa-mobile"></i> {{ $setting->phone }}</a></div>
                @endif
            </div>
            <div class="col-md-3 col-6 order-4 order-md-4">
                @if (!empty($setting->phone_two))
                    <div><a class="phone-number-01" href="{{ 'tel:' . $setting->phone_two }}" dir="ltr"><i class="fas fa-mobile"></i> {{ $setting->phone_two }}</a></div>
                @endif
            </div>
        </div>
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

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const icon = this.querySelector('i');
    const facilities = document.querySelector('.facilities-03');
    if (window.innerWidth < 768) { // Check if screen size is less than md (768px)
                facilities.style.marginBottom = '-70px';
            } else {
                facilities.style.marginBottom = '-45px';
            }
    // facilities.style.marginBottom = '-45px';
    document.querySelector('.toggle-icon-03').addEventListener('click', function () {
        const icon = this.querySelector('i');
        const facilities = document.querySelector('.facilities-03');

        facilities.style.marginBottom = '-45px';

        if (icon.classList.contains('fa-chevron-up')) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            if (window.innerWidth < 768) { // Check if screen size is less than md (768px)
                facilities.style.marginBottom = '0px';
            } else {
                facilities.style.marginBottom = '0px';
            }
        } else {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            if (window.innerWidth < 768) { // Check if screen size is less than md (768px)
                facilities.style.marginBottom = '-70px';
            } else {
                facilities.style.marginBottom = '-45px';
            }
        }
    });
});



    </script>