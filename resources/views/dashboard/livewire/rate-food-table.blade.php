<div>
    <style>
        .stars {
            display: inline-flex;
            gap: 5px;
        }
        .rating-table {
            width: 100%;
            text-align: center;
            vertical-align: middle;
            border-collapse: collapse;
        }
        .rating-table td {
            padding: 10px;
            vertical-align: middle;
        }
    </style>
    {{-- @include('dashboard.livewire.menu-table') --}}
    <div class="m-4">
        <div class="row justify-content-between">

            <h2 class="text-lg text-white font-medium mr-auto">
                <b>{{__('TABLE RATING')}}</b>
            </h2>
        </div>
        <div class="row">

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Search')}}</label>
                    <input type="search" wire:model="search" class="form-control bg-white text-black w-100"
                        placeholder="{{__('Search...')}}" style="width: 250px; border: 1px solid var(--primary)" />
                </h6>

                <h6 class=" font-medium col-12 col-lg-2">
                    <label class="text-white">{{__('Options Select')}}</label>
                    <select wire:model="optionFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>{{__('All')}}</option>
                        <option value="2">{{__('Very Bad')}}</option>
                        <option value="3">{{__('Bad')}}</option>
                        <option value="4">{{__('Good')}}</option>
                        <option value="4.9">{{__('Very Good')}}</option>
                        <option value="5">{{__('Excellent')}}</option>
                    </select>
                </h6>
            {{-- <div>
                <div class="">
                    <button class="btn btn-info" data-toggle="modal"
                        data-target="#menuModal">{{__('Add New Menu')}}</button>
                </div>
            </div> --}}
        </div>
        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark rating-table">
                <thead>
                    <tr>
                        @foreach ($cols_th as $col)
                        <th>{{ __($col) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        @foreach ($cols_td as $col)
                            <td class="align-middle">
                                @if($col === 'id')
                                    {{ $item['id'] }}
                                @elseif($col === 'customer.first_name')
                                    {{ $item['customer']['first_name'] }}
                                @elseif($col === 'customer.last_name')
                                    {{ $item['customer']['last_name'] }}
                                @elseif($col === 'customer.dob')
                                    {{ $item['customer']['dob'] }}
                                @elseif($col === 'customer.phone')
                                    {{ $item['customer']['phone'] }}
                                @elseif($col === 'food.translation.name')
                                    {{ $item['food']['translation']['name'] }}
                                @elseif($col === 'food.img')
                                    <img src="{{ app('cloudfront').$item['food']['img'] }}" alt="{{ $item['food']['translation']['name'] }}" width="150">
                                @elseif($col === 'rating')
                                <table class="stars">
                                    <tr>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++) 
                                            <i class="{{ $item['rating'] >= $i ? 'fas fa-star' : 'far fa-star' }} fa-star-stroke {{$item['rating'] >= $i ? 'text-warning' : '' }}"></i> 
                                            @endfor  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if($item['rating'] <= 1.9)
                                            <span class="text-danger"><b>{{__('Very Bad')}} {{ $item['rating'] }}</b></span>
                                            @elseif($item['rating'] <= 2.9)
                                            <span class="text-danger"><b>{{__('Bad')}} {{ $item['rating'] }}</b></span>
                                            @elseif($item['rating'] <= 3.9)
                                            <span class="text-warning"><b>{{__('Good')}} {{ $item['rating'] }}</b></span>
                                            @elseif($item['rating'] <= 4.9)
                                            <span class="text-success"><b>{{__('Very Good')}} {{ $item['rating'] }}</b></span>
                                            @elseif($item['rating'] == 5)
                                            <span class="text-info"><b>{{__('Excellent')}} {{ $item['rating'] }}</b></span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @else
                                    {{ $item[$col] }}
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
@if(session()->has('alert'))
    @php $alert = session()->get('alert'); @endphp
    <script>
        toastr.{{ $alert['type'] }}('{{ $alert['message'] }}');
    </script>
@endif
@push('cropper')
<script>
    function updatePriorityValue(itemId) {
        var input = document.getElementById('priority_' + itemId);
        var updatedPriority = input.value;
        @this.call('updatePriority', itemId, updatedPriority);
    }
</script>
@endpush