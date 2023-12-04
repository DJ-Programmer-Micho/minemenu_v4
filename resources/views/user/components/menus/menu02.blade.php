<div class=" my-3">
    <div class="wrapper-02">
        <ul class="nav nav-pills-02 tabs-box-02 flex-nowrap" id="pills-tab" role="tablist">
                @foreach ($menuData as $item)
                <li class="nav-item tab-02" role="presentation">
                    <button class="btn btn-link nav-link-02 equal-width {{$loop->index == 0 ? 'active' : ''}}" id="pills-{{$item->id}}-tab" data-toggle="pill" data-target="#pills-{{$item->id}}" type="button" role="tab" aria-controls="pills-{{$item->id}}" aria-selected="true">{{$item->translation->name}}</button>
                </li>
                @endforeach
                <li class="nav-item tab-02" role="presentation">
                    <button class="btn btn-link nav-link-02 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
        </ul>
    </div>

    <div class="tab-content" id="pills-tabContent">
        @foreach ($menuData as $menu)
        <div class="tab-pane fade {{$loop->index == 0 ? 'show active' : ''}}" id="pills-{{$menu->id}}" role="tabpanel"
            aria-labelledby="pills-{{$menu->id}}-tab">
            <x-business.Category01Component :menuid="$menu->translation->menu_id" :user="$user_id" :glang="$glang" :ui="$ui" />
        </div>
        @endforeach
        <div class="tab-pane fade" id="pills-social" role="tabpanel"
        aria-labelledby="pills-social-tab">
        <h3 class="text-center mt-3" style="color: var(--main-theme-text-color)">{{__('Join With Us')}}</h3>
       <div class="row">
        @if ($setting->facebook)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->facebook}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/face.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->instagram)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->instagram}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/insta.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->telegram)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->telegram}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/tele.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->snapchat)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->snapchat}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/snap.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->tiktok)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->tiktok}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/tik.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->website)                
        <div class="col-4 col-md-3 p-1">
            <a href="{{$setting->website}}" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('assets/main/img/socialicon/globe.png')}}" alt="" srcset="" width="100%">
            </a>
        </div>
        @endif
        @if ($setting->map)                
        <div class="col-12 p-1">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6843700.223358107!2d38.42699792131716!3d33.11827106518673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1557823d54f54a11%3A0x6da561bba2061602!2sIraq!5e0!3m2!1sen!2siq!4v1695229906131!5m2!1sen!2siq" width="100%" height="180%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        @endif
       </div>
    </div>
    </div>
</div>

<script>
    const tabsBox = document.querySelector('.tabs-box-02'),
        lang = document.documentElement.getAttribute('lang');
    let isDragging = false;

    const handleIcons = scrollVal => {
        let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;


    };

    tabsBox.addEventListener('scroll', () => {
        handleIcons(tabsBox.scrollLeft);
    });

    const dragging = e => {
        if (!isDragging) return;
        tabsBox.classList.add('dragging');
        tabsBox.scrollLeft -= e.movementX;
        handleIcons(tabsBox.scrollLeft);
    };

    const dragStop = () => {
        isDragging = false;
        tabsBox.classList.remove('dragging');
    };

    tabsBox.addEventListener('mousedown', () => (isDragging = true));
    tabsBox.addEventListener('mousemove', dragging);
    document.addEventListener('mouseup', dragStop);

    const buttons = document.querySelectorAll('.equal-width');
    let maxWidth = 0;

    // Calculate the maximum width among the buttons
    buttons.forEach(button => {
        const width = button.offsetWidth;
        if (width > maxWidth) {
            maxWidth = width;
        }
    });

    // Set the same width for all buttons
    buttons.forEach(button => {
        button.style.minWidth = maxWidth + 'px';
    });
</script>