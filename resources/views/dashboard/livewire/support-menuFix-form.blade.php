<div class="my-4">
    <div class="d-flex align-items-center">
        <h3 class="text-white">{{__('Check Requirements')}}</h3>
        <lord-icon
        src="https://cdn.lordicon.com/hdiorcun.json"
        trigger="loop"
        delay="2000"
        colors="primary:#ccc,secondary:#cc0022"
        style="width:60px;height:60px">
    </lord-icon>
    </div>
    <hr class="bg-white">
    <div class="container">
        <button class="btn btn-info" wire:click="checkRequirements">{{__('Check Requirements')}}</button>
        @if ($showRequirements == false && $analysing == false)
        <div class="mt-3">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Offers Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Menus Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Categories Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Food Name Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Food Descriprtion Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyze The Options Section')}}</h6>
                    </div>
                </div>
            </div>
        </div>
        @elseif($showRequirements == false && $analysing == true)
        <div class="mt-3">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Offers Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Menus Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Categories Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Food Name Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Food Descriprtion Section')}}</h6>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="d-flex">
                        <i class="fas fa-spinner fa-spin" style="color: #ddd"></i>&nbsp;
                        <h6 class="text-white"> {{__('Analyzing... The Options Section')}}</h6>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="mt-3">
            @if (count($messages) > 0)
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['offer']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Offer Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['offer'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Offers Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['menu']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Menu Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['menu'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Menus Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['category']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Category Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['category'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Categories Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['name']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Food Name Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['name'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Food Name Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['description']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Description Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['description'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Food Description Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-4 mb-3">
                    <div class="p-2 card h-100 bg-dark border">
                        @if (isset($messages['option']))
                        <div class="d-flex">
                            <i class="fab fa-slack-hash" style="color: #ddd"></i>&nbsp; 
                            <h6 class="text-white">{{__('Options Issue Found')}}</h6>
                        </div>
                        <ul>
                            @foreach ($messages['option'] as $message)
                        <li class="d-flex">
                            <i class="fas fa-times text-danger"></i>&nbsp;
                            <h6 class="text-white"> {{$message}}</h6>
                        </li>
                            @endforeach
                        </ul>    
                        @else
                        <div class="d-flex">
                            <i class="fas fa-check text-success"></i>&nbsp;
                            <h6 class="text-white"> {{__('No Problem Found In Options Section')}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>