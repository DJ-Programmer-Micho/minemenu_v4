<form wire:submit.prevent="saveDesign">
    @php
    $designGroups = [
        [
            'name' => 'navbar',
            'group_design' => __('Design Group For Navbar'),
            'designs' => [
                ['id' => '01', 'name' => 'Navbar N1', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '02', 'name' => 'Navbar N1', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '03', 'name' => 'Navbar N1', 'image' => app('cloudfront').'mine-setting/phone.png'],
            ],
        ],
        [
            'name' => 'header',
            'group_design' => __('Design Group For Header'),
            'designs' => [
                ['id' => '01', 'name' => 'Header H1', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '02', 'name' => 'Header H2', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '03', 'name' => 'Header H3', 'image' => app('cloudfront').'mine-setting/phone.png'],
            ],
        ],
        [
            'name' => 'offer',
            'group_design' => __('Design Group For Offer'),
            'designs' => [
                ['id' => '01', 'name' => 'Offer O1', 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr01.jpg'],
                ['id' => '02', 'name' => 'Offer O2', 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr02.jpg'],
                ['id' => '03', 'name' => 'Offer O3', 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr03.jpg'],
                ['id' => '04', 'name' => 'Offer O4', 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr04.jpg'],
            ],
        ],
        [
            'name' => 'menu',
            'group_design' => __('Design Group For Menu'),
            'designs' => [
                ['id' => '01', 'name' => 'Menu M1', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '02', 'name' => 'Menu M2', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
            ],
        ],
        [
            'name' => 'category',
            'group_design' => __('Design Group For Category'),
            'designs' => [
                ['id' => '01', 'name' => 'Category C1', 'image' => app('cloudfront').'mine-setting/ui-ux/cat01.jpg'],
                ['id' => '02', 'name' => 'Category C2', 'image' => app('cloudfront').'mine-setting/ui-ux/cat02.jpg'],
                ['id' => '03', 'name' => 'Category C3', 'image' => app('cloudfront').'mine-setting/ui-ux/cat03.jpg'],
                ['id' => '04', 'name' => 'Category C4', 'image' => app('cloudfront').'mine-setting/ui-ux/cat04.jpg'],
                ['id' => '05', 'name' => 'Category C5', 'image' => app('cloudfront').'mine-setting/ui-ux/cat05.jpg'],
                ['id' => '06', 'name' => 'Category C6', 'image' => app('cloudfront').'mine-setting/ui-ux/cat06.jpg'],
                ['id' => '07', 'name' => 'Category C7', 'image' => app('cloudfront').'mine-setting/ui-ux/cat07.jpg'],
            ],
        ],
        [
            'name' => 'food_list',
            'group_design' => __('Design Group For Food List'),
            'designs' => [
                ['id' => '01', 'name' => 'Food F1', 'image' => app('cloudfront').'mine-setting/ui-ux/food01.jpg'],
                ['id' => '02', 'name' => 'Food F2', 'image' => app('cloudfront').'mine-setting/ui-ux/food02.jpg'],
                ['id' => '03', 'name' => 'Food F3', 'image' => app('cloudfront').'mine-setting/ui-ux/food03.jpg'],
                ['id' => '04', 'name' => 'Food F4', 'image' => app('cloudfront').'mine-setting/ui-ux/food04.jpg'],
            ],
        ],
        [
            'name' => 'food_detail',
            'group_design' => __('Design Group For Food Detail'),
            'designs' => [
                ['id' => '01', 'name' => 'Detail FD1', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '02', 'name' => 'Detail FD2', 'image' => app('cloudfront').'mine-setting/phone.png'],
                ['id' => '03', 'name' => 'Detail FD3', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '04', 'name' => 'Detail FD4', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
            ],
        ],
        [
            'name' => 'offer_detail',
            'group_design' => __('Design Group For Offer Detail'),
            'designs' => [
                ['id' => '01', 'name' => 'Detail OD1', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '02', 'name' => 'Detail OD2', 'image' => app('cloudfront').'mine-setting/phone.png'],
                ['id' => '03', 'name' => 'Detail OD3', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '04', 'name' => 'Detail OD4', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
            ],
        ],
    ];
    
    $selectedDesigns = [];
    @endphp

    @foreach ($designGroups as $group)
        <div class="mt-4">
            <strong class="text-white">{{ $group['group_design'] }}</strong>
            <br>

            <div class="row">
            @foreach ($group['designs'] as $design)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 p-1 mb-3">
                    <label class="d-flex align-items-center text-left">
                        <div>
                            <input class="form-control text-white" type="radio" name="{{ $group['name'] }}" wire:model="selectedDesigns.{{ $group['name'] }}" value="{{ $design['id'] }}"
                            {{ in_array($design['id'], $selectedDesigns) ? 'checked' : '' }}>

                        </div>
                        <div>
                            <span class="text-white mx-1">{{ $design['name'] }}</span>
                        </div>
                        
                    </label>

                    <img src="{{ asset($design['image']) }}" alt="{{ $design['name'] }} Preview" width="100%" style="border: 1px solid #aaa">
                </div>
                <br>
                @endforeach
            </div>
            <hr class="bg-white">
        </div>
    @endforeach

    <button type="submit" class="btn btn-info">Submit Design</button>
    <!-- Add a submit button or JavaScript to handle form submission -->
</form>