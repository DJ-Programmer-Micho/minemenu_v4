<div>
    @include('dashboard.livewire.category-form')
    <div class="my-4">
        <div class="d-flex justidy-content-between mb-4">
            <h2 class="text-lg font-medium mr-auto">
                <b class="text-uppercase text-white">{{__('category table')}}</b>
            </h2>
            <div class="">
                <button class="btn btn-info" data-toggle="modal" data-target="#createCategory">{{__('Add New Category')}}</button>
            </div>
        </div>
        <div class="row m-0 p-0">
            
                <h6 class="\ font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Menu Select')}}</label>
                    <select wire:model="mainmenuFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>{{__('All')}}</option>
                        @foreach ($menu_select as $menu)
                        <option value="{{$menu->translation->name}}">{{$menu->translation->name}}</option>
                        @endforeach
                    </select>
                </h6>

                <h6 class=" font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Category Search')}}</label>
                    <input type="search" wire:model="search" class="form-control bg-white text-black w-100"
                        placeholder="{{__('Search...')}}" style="width: 250px; border: 1px solid var(--primary)" />
                </h6>

                <h6 class=" font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Status Select')}}</label>
                    <select wire:model="statusFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>{{__('All')}}</option>
                        <option value="1">{{__('Active')}}</option>
                        <option value="0">{{__('Non-Active')}}</option>
                    </select>
                </h6>
           
                <h6 class=" font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Reset Filter')}}</label>
                    <button class="btn btn-dark form-control py-0" wire:click="resetFilter()">{{__('Reset')}}</button>
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
                            @elseif ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                            @elseif ($col === 'img') <!-- Add this condition -->
                                <img src="{{ app('cloudfront').$item->img }}" alt="{{ $item->translation->name }}" width="150" style="border-radius: 10px;">
                            @elseif ($col === 'cover') <!-- Add this condition -->
                                @if ($item->cover)
                                <img src="{{ app('cloudfront').$item->cover}}" alt="{{ $item->translation->name }}" width="150" style="border-radius: 10px;">
                                @else
                                <img src="{{ $emptyImg }}" alt="{{ $item->translation->name }}" width="150" style="border-radius: 10px;">
                                @endif
                            @elseif ($col === 'priority')        
                                <input type="number" id="priority_{{ $item->id }}" value="{{ $item->priority }}" class="form-control bg-dark text-white">
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td class="align-middle">
                            <button type="button" onclick="updatePriorityValue({{ $item->id }})" class="btn btn-warning btn-icon text-dark">
                                <i class="fas fa-sort"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#updateCategoryModal" wire:click="editCategory({{ $item->id }})" class="btn btn-primary btn-icon">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" wire:click="updateStatus({{ $item->id }})" class="btn {{ $item->status == 1 ? 'btn-danger' : 'btn-success' }} btn-icon">
                            <i class="far {{ $item->status == 1 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteCategoryModal" wire:click="deleteCategory({{ $item->id }})" class="btn btn-danger btn-icon">
                            <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
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

{{-- @push('rest_css') --}}
<style>
    .btn-icon {
        margin: 2px;
        width: 40px;
        /* Adjust as needed */
        height: 40px;
        /* Adjust as needed */

    }

    .btn-icon i {
        font-size: 16px;
        /* Adjust the icon size as needed */
    }
</style>
{{-- @endpush --}}