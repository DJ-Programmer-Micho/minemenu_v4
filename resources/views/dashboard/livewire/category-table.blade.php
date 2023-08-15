<div>

    @include('dashboard.livewire.category-form')
    <div class="m-4">
        <div class="d-flex justidy-content-between">
            <h2 class="text-lg font-medium mr-auto">
                <b class="text-uppercase">{{__('category table')}}</b>
            </h2>
            <div class="">
                <button class="btn btn-info" data-toggle="modal" data-target="#createCategory">{{__('Add New Category')}}</button>
            </div>
        </div>
        <div class="row m-0 p-0">
            
                <h2 class="text-lg font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Menu Select')}}</label>
                    <select wire:model="mainmenuFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>All</option>
                        @foreach ($menu_select as $menu)
                        <option value="{{$menu->translation->name}}">{{$menu->translation->name}}</option>
                        @endforeach
                    </select>
                </h2>

                <h2 class="text-lg font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Category Search')}}</label>
                    <input type="search" wire:model="search" class="form-control bg-white text-black w-100"
                        placeholder="Search..." style="width: 250px; border: 1px solid var(--primary)" />
                </h2>

                <h2 class="text-lg font-medium col-12 col-lg-3">
                    <label class="text-white">{{__('Status Select')}}</label>
                    <select wire:model="statusFilter" class="form-control bg-white text-black w-100">
                        <option value="" default>All</option>
                        <option value="1">Active</option>
                        <option value="0">Non-Active</option>
                    </select>
                </h2>
           


 
        </div>
        </div>
        @if (session()->has('message'))
        <h5 class="alert alert-success">{{ session('message') }}</h5>
        @endif
 
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm table-dark">
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
                        <td>
                            @if ($col === 'status')
                                <span class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                   <b>{{ $item->status == 1 ? __('Active') : __('Non-Active') }}</b>
                                </span>
                            @elseif ($col === 'img') <!-- Add this condition -->
                                <img src="{{ app('cloudfront').$item->img }}" alt="{{ $item->translation->name }}" width="150">
                            @else
                                {{ data_get($item, $col) }}
                            @endif
                        </td>
                        @endforeach
                        <td>
                            <button type="button" data-toggle="modal" data-target="#updateCategoryModal"
                                wire:click="editCategory({{ $item->id }})" class="btn btn-primary m-1">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#deleteStudentModal"
                                wire:click="deleteStudent({{ $item->id }})" class="btn btn-danger m-1">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button"
                                wire:click="updateStatus({{ $item->id }})"
                                class="btn {{ $item->status == 1 ? 'btn-danger' : 'btn-success' }} m-1">
                                <i class="far {{ $item->status == 1 ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($cols_th) + 1 }}">No Record Found</td>
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
