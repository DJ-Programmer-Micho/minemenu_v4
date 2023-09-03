<form wire:submit.prevent="saveDesign">
    @php
    $designGroups = [
        [
            'name' => 'header',
            'group_design' => 'Design Group Header',
            'designs' => [
                ['id' => '01', 'name' => 'Design A1', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '02', 'name' => 'Design A2', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '03', 'name' => 'Design A3', 'image' => app('cloudfront').'mine-setting/phone.png'],
            ],
        ],
        [
            'name' => 'navbar',
            'group_design' => 'Design Group Navbar',
            'designs' => [
                ['id' => '01', 'name' => 'Design B1', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '02', 'name' => 'Design B2', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
            ],
        ],
        [
            'name' => 'menu',
            'group_design' => 'Design Group Menu',
            'designs' => [
                ['id' => '01', 'name' => 'Design B1', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
                ['id' => '02', 'name' => 'Design B2', 'image' => app('cloudfront').'mine-setting/phone.png'],
                ['id' => '03', 'name' => 'Design B3', 'image' => app('cloudfront').'mine-setting/Capture.PNG'],
                ['id' => '04', 'name' => 'Design B4', 'image' => app('cloudfront').'mine-setting/IMG_9633.PNG'],
            ],
        ],
    ];
    
    $selectedDesigns = [];
    @endphp

    @foreach ($designGroups as $group)
        <div>
            <strong>{{ $group['group_design'] }}</strong>
            <br>

            <div class="row">
            @foreach ($group['designs'] as $design)
                <div class="col-12 col-md-6 col-lg-3">
                    <label>
                        <input class="form-control" type="radio" name="{{ $group['name'] }}" wire:model="selectedDesigns.{{ $group['name'] }}" value="{{ $design['id'] }}"
                        {{ in_array($design['id'], $selectedDesigns) ? 'checked' : '' }}>
                        {{ $design['name'] }}
                    </label><br>

                    <img src="{{ asset($design['image']) }}" alt="{{ $design['name'] }} Preview" width="180">
                </div>
                <br>
                @endforeach
            </div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-info">Submit Design</button>
    <!-- Add a submit button or JavaScript to handle form submission -->
</form>