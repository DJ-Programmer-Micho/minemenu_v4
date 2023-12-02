<div>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- @include('dashboard.livewire.food-form') --}}
    <div class="my-4">
        <div class="d-flex justidy-content-between mb-4">
            <h2 class="text-lg font-medium mr-auto">
                <b class="text-uppercase text-white">{{__('User Data Table')}} - {{$counter}}</b>
            </h2>
            <div class="">
                <button type="button" class="btn btn-info" wire:click="export('{{$planFilter_send}}','{{$searchFilter_send}}','{{$dateRange_send}}','{{$countryFilter_send}}')">{{__('Print Report')}}</button>
            </div>
        </div>
        <div class="row m-0 p-0">
            <h6 class=" font-medium col-12 col-lg-2">
                <label class="text-white">{{__('Date Select')}}</label>
                <div id="reportrange"  class="form-control bg-white text-black" style="cursor: pointer; padding: 5px 10px; border: 1px solid #333; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Name Search')}}</label>
                    <input type="search" wire:model="searchFilter" class="form-control bg-white text-black w-100"
                        placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Country Select')}}</label>
                    <select wire:model="countryFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>All</option>
                        @foreach ($countryData as $country)
                        <option value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </select>
                </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Plan Select')}}</label>
                    <select wire:model="planFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>All</option>
                        @foreach ($planSelect as $plan)
                            <option value="{{$plan->id}}">{{$plan->name['en']}}</option>
                        @endforeach
                    </select>
                </h6>


           
                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Reset Filter')}}</label>
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">Reset</button>
                </h6>



 
        </div>
        </div>
        {{-- @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col )
                        <th>{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $item )
                    <tr>
                        @foreach ($cols_td as $col)
                        <td class="align-middle">
                            @if($col === 'id')
                                {{$index +1 }}
                                @elseif ($col === 'user_id')
                                <span>{{ $item->id }}</span>
                                @elseif ($col === 'name')
                                <span>{{ $item->name }}</span>
                                @elseif ($col === 'background_img_avatar')
                                <img src="{{ $defualt_link . ($item->settings->background_img_avatar ?? $default_img) }}" alt="{{ $item[$col] }}" width="50" style="border-radius: 50%;">
                                @elseif ($col === 'author')
                                <span>{{ $item->profile->fullname ?? 'Error'}}</span>
                                @elseif ($col === 'plan_id') <!-- Add this condition -->
                                <span class="text-success">
                                    <b>{{ $planNames[$item->subscription->plan_id] ?? 'Error' }}</b>
                                </span> 
                                @elseif ($col === 'country') <!-- Add this condition -->
                                <span>{{ $item->profile->country }} - {{ $item->profile->address }}</span> 
                                @elseif ($col === 'Action') <!-- Add this condition -->
                                <button class="btn btn-info mx-1 mb-1" onclick="checkBusiness('{{$general_link.$item->name}}')"><i class="far fa-eye"></i></button>
                                <button class="btn btn-secondary mx-1" wire:click="checkDashboard('{{$item->id}}')"><i class="fas fa-satellite-dish"></i></button>
                                @else
                                {{ $item->$col }}
                                @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">{{__('No Record Found')}}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="dark:bg-gray-800 dark:text-white">
            {{ $items->links() }}
        </div>

    </div>
</div>
</div>

</div>

@push('datePicker')
    
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {
    var start =  moment().startOf('year');
    var end = moment().endOf('year');
    
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // Update Livewire component property
        @this.set('dateRange', start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        // Emit Livewire event
        @this.emit('dateRangeSelected');
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb);
    cb(start, end);

});
</script>
<script>
    function checkBusiness($link){
        window.open($link, '_blank');
    }


    document.addEventListener('livewire:load', function () {
        Livewire.on('clicked', function (url, link) {
            alert('Username: '+ url + '\n' + 'password: ' + link) 
        });
    });

</script>
@endpush
{{-- @endpush --}}