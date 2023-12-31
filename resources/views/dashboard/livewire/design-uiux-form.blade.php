<form wire:submit.prevent="saveDesign">
    @php
    $designGroups = [
        [
            'name' => 'navbar',
            'group_design' => __('Group Design For Navbar'),
            'designs' => [
                ['id' => '01', 'name' => __('Navbar N1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Navbar_N1.jpg'],
                ['id' => '02', 'name' => __('Navbar N2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Navbar_N2.jpg'],
                ['id' => '03', 'name' => __('Navbar N3'), 'image' => app('cloudfront').'mine-setting/ui-ux/Navbar_N3.jpg'],
            ],
        ],
        [
            'name' => 'header',
            'group_design' => __('Group Design For Header'),
            'designs' => [
                ['id' => '01', 'name' => __('Header H1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Header_H1.jpg'],
                ['id' => '02', 'name' => __('Header H2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Header_H2.jpg'],
                ['id' => '03', 'name' => __('Header H3'), 'image' => app('cloudfront').'mine-setting/ui-ux/Header_H3.jpg'],
            ],
        ],
        [
            'name' => 'offer',
            'group_design' => __('Group Design For Offer'),
            'designs' => [
                ['id' => '01', 'name' => __('Offer O1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr01.jpg'],
                ['id' => '02', 'name' => __('Offer O2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr02.jpg'],
                ['id' => '03', 'name' => __('Offer O3'), 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr03.jpg'],
                ['id' => '04', 'name' => __('Offer O4'), 'image' => app('cloudfront').'mine-setting/ui-ux/Ofr04.jpg'],
            ],
        ],
        [
            'name' => 'menu',
            'group_design' => __('Group Design For Menu'),
            'designs' => [
                ['id' => '01', 'name' => __('Menu M1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Menu_M1.jpg'],
                ['id' => '02', 'name' => __('Menu M2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Menu_M2.jpg'],
            ],
        ],
        [
            'name' => 'category',
            'group_design' => __('Group Design For Category'),
            'designs' => [
                ['id' => '01', 'name' => __('Category C1'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat01.jpg'],
                ['id' => '02', 'name' => __('Category C2'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat02.jpg'],
                ['id' => '03', 'name' => __('Category C3'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat03.jpg'],
                ['id' => '04', 'name' => __('Category C4'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat04.jpg'],
                ['id' => '05', 'name' => __('Category C5'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat05.jpg'],
                ['id' => '06', 'name' => __('Category C6'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat06.jpg'],
                ['id' => '07', 'name' => __('Category C7'), 'image' => app('cloudfront').'mine-setting/ui-ux/cat07.jpg'],
            ],
        ],
        [
            'name' => 'food_list',
            'group_design' => __('Group Design For Food List'),
            'designs' => [
                ['id' => '01', 'name' => __('Food F1'), 'image' => app('cloudfront').'mine-setting/ui-ux/food01.jpg'],
                ['id' => '02', 'name' => __('Food F2'), 'image' => app('cloudfront').'mine-setting/ui-ux/food02.jpg'],
                ['id' => '03', 'name' => __('Food F3'), 'image' => app('cloudfront').'mine-setting/ui-ux/food03.jpg'],
                ['id' => '04', 'name' => __('Food F4'), 'image' => app('cloudfront').'mine-setting/ui-ux/food04.jpg'],
            ],
        ],
        [
            'name' => 'food_detail',
            'group_design' => __('Group Design For Food Detail'),
            'designs' => [
                ['id' => '01', 'name' => __('Detail FD1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_FD1.jpg'],
                ['id' => '02', 'name' => __('Detail FD2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_FD2.jpg'],
                ['id' => '03', 'name' => __('Detail FD3'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_FD3.jpg'],
                ['id' => '04', 'name' => __('Detail FD4'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_FD4.jpg'],
            ],
        ],
        [
            'name' => 'offer_detail',
            'group_design' => __('Group Design For Offer Detail'),
            'designs' => [
                ['id' => '01', 'name' => __('Detail OD1'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_OD1.jpg'],
                ['id' => '02', 'name' => __('Detail OD2'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_OD2.jpg'],
                ['id' => '03', 'name' => __('Detail OD3'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_OD3.jpg'],
                ['id' => '04', 'name' => __('Detail OD4'), 'image' => app('cloudfront').'mine-setting/ui-ux/Detail_OD4.jpg'],
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
<div class="text-center mb-3">
    <button type="submit" class="btn btn-info">{{__('Submit Design')}}</button>
</div>
    <!-- Add a submit button or JavaScript to handle form submission -->
</form>