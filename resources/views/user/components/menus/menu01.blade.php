<div class=" my-3">
    <div class="wrapper-01">
        <ul class="nav nav-pills-01 tabs-box-01 flex-nowrap" id="pills-tab" role="tablist">
                @foreach ($menuData as $item)
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width {{$loop->index == 0 ? 'active' : ''}}" id="pills-{{$item->id}}-tab" data-toggle="pill" data-target="#pills-{{$item->id}}" type="button" role="tab" aria-controls="pills-{{$item->id}}" aria-selected="true">{{$item->translation->name}}</button>
                </li>
                @endforeach
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
                <li class="nav-item tab-01" role="presentation">
                    <button class="nav-link-01 equal-width" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                        type="button" role="tab" aria-controls="pills-social"
                        aria-selected="true">{{__("Follow Us")}}</button>
                </li>
        </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
        @foreach ($menuData as $menu)
        <div class="tab-pane fade {{$loop->index == 0 ? 'show active' : ''}}" id="pills-{{$menu->id}}" role="tabpanel"
            aria-labelledby="pills-{{$menu->id}}-tab">
            <x-business.category01component :menuid="$menu->translation->menu_id" :user="$user_id" :glang="$glang" :ui="$ui" />
        </div>
        @endforeach
    </div>
</div>

<script>
    const tabsBox = document.querySelector('.tabs-box-01'),
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