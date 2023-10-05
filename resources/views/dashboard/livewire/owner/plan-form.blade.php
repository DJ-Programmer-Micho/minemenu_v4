<div>
    <!-- Insert Plan  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createPlan" tabindex="-1" aria-labelledby="createPlanLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="savePlan">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createFoodLabel">{{__('Add Food')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="row mt-3">
                            {{-- <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Utilities')}}</b>
                                </h2>
                            </div> --}}
                            {{-- <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{ __('Select Menu') }}</label>
                                    <select wire:model="cat_id" name="cat_id" id="" class="form-control">
                                        <option value="">Select Menu</option>
                                        @foreach ($menu_select as $menu)
                                        <option value="{{$menu->translation->cat_id}}">{{$menu->translation->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-info">{{__('Select The Group')}}</small>
                                    @error('cat_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="" class="form-control">
                                        <option value="">Choose Status</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                        <small class="tetx-info">{{__('Show or Hide')}}</small>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div> --}}
                            {{-- <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Priority')}}</label>
                                    <input type="number" wire:model="priority" class="form-control">
                                    <small class="text-info">{{__('The less The Higher Priority')}}</small>
                                    @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> --}}
                            {{-- <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Special')}}</label>
                                    <select wire:model="special" name="special" id="" class="form-control">
                                        <option value="">Choose Special On/Off</option>
                                        <option value="1">{{__('Special')}}</option>
                                        <option value="0">{{__('Non Special')}}</option>
                                        <small class="tetx-info">{{__('Show or Hide')}}</small>
                                    </select>
                                    @error('special') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div> --}}
                        </div>
                        <div class="row mt-5">
                            
                        </div>
                        <div class="row mt-5">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Title & Description')}}</b>
                                </h2>
                                <div class="">
                                </div>
                            </div>
                            @foreach ($filteredLocales as $locale)
                            <div class="col-12 col-sm-6 border">
                                <div class="mb-3">
                                    <label>{{ strtoupper($locale) }}</label>
                                    <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                    @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Desctip{{ strtoupper($locale) }}</label>
                                    <textarea wire:model="description.{{$locale}}" class="form-control"
                                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}"></textarea>
                                    @error('description.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitJs">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Insert Edit  -->
    {{-- <div wire:ignore.self class="modal fade" id="updateFoodModal" tabindex="-1" aria-labelledby="updateFoodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl text-white">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateFood">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateFoodModalLabel">{{__('Edit Menu')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                                aria-label="Close"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="row mt-5">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Utilities')}}</b>
                                </h2>
                                <div class="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{ __('Select Menu') }}</label>
                                    <select wire:model="cat_id" name="cat_id" id="" class="form-control">
                                        <option value="">Select Menu</option>
                                        @foreach ($menu_select as $menu)
                                        <option value="{{$menu->translation->cat_id}}">{{$menu->translation->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-info">{{__('Select The Group')}}</small>
                                    @error('cat_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Status')}}</label>
                                    <select wire:model="status" name="status" id="" class="form-control">
                                        <option value="">Choose Status</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                    </select>
                                    <small class="text-info">{{__('Show or Hide')}}</small>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Priority')}}</label>
                                    <input type="number" wire:model="priority" class="form-control">
                                    <small class="text-info">{{__('The less The Higher')}}</small>
                                    @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label>{{__('Special')}}</label>
                                    <select wire:model="special" name="special" id="" class="form-control">
                                        <option value="">Choose Special On/Off</option>
                                        <option value="1">{{__('Special')}}</option>
                                        <option value="0">{{__('Non Special')}}</option>
                                        <small class="tetx-info">{{__('Show or Hide')}}</small>
                                    </select>
                                    @error('special') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Title & Description')}}</b>
                                </h2>
                                <div class="">
                                </div>
                            </div>
                            @foreach ($filteredLocales as $locale)
                            <div class="col-12 col-sm-6 border">
                                <div class="mb-3">
                                    <label>{{ strtoupper($locale) }}</label>
                                    <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                    @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Desctip{{ strtoupper($locale) }}</label>
                                    <textarea wire:model="description.{{$locale}}" class="form-control"
                                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}"></textarea>
                                    @error('description.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                Single Price
                                <label class="switch"> <input type="checkbox" wire:model="showTextarea"
                                        id="customSwitch1"><span class="slider"></span></label>
                                Multi Price
                            </div>
                            @if ($showTextarea)
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Multiple Prices')}}</b>
                                </h2>
                                <div class="">
                                    <button type="button" class="btn btn-primary" wire:click="addOptionForAllAndLocale('all')">{{__('Add All Option')}}</button> 
                                </div>
                            </div>
                            @foreach ($filteredLocales as $locale)
                            <div class="col-12 col-sm-6 border">
                                <div class="d-flex justify-content-between my-3">
                                    <h3>{{ strtoupper($locale) }}</h3>
                                    <button type="button" class="btn btn-info" wire:click="addOptionForAllAndLocale('{{$locale}}')">{{__('Add Specific Option')}}</button> 
                                </div>
                                @php
                                    $localeOptions = $options[$locale] ?? [];
                                @endphp
                            
                                @if (empty($localeOptions))
                                    <!-- Generate one empty option if there are no options for this locale -->
                                    @php
                                        $localeOptions[] = ['key' => '', 'value' => ''];
                                    @endphp
                                @endif
                            
                                @foreach ($localeOptions as $index => $option)
                                    <h6>{{__('Option No.')}} {{$index+1}}</h6>
                                    <div class="row align-items-bottom">
                                        <div class="form-group col-12 col-md-6 col-lg-5">
                                            <label>Option Description</label>
                                            <input type="text" wire:model="options.{{ $locale }}.{{ $index }}.key" class="form-control">
                                            <small class="text-info">{{__('exp:(Small, Medium and Large)')}}</small>
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-5">
                                            <label>Price</label>
                                            <input type="number" wire:model="options.{{ $locale }}.{{ $index }}.value" class="form-control">
                                            <small class="text-info">{{__('(Original Price)')}}</small>
                                            <button type="button" class="btn btn-warning text-dark" wire:click="setSamePriceForAllLocales('{{ $locale }}', {{ $index }})">Set Same Price for All</button>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <label class="d-lg-block d-none">Remove</label>
                                            <button type="button" class="btn btn-danger" wire:click="removeOption('{{ $locale }}', {{ $index }})"><i class="fas fa-minus-square"></i></button>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                            @endforeach
                            
                            
                            


                            

                            @else
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Single Price')}}</b>
                                </h2>
                                <div class="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" wire:model="price" class="form-control" id="price">
                                    <small class="text-info">{{__('(Original Price)')}}</small>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="oldPrice">Old Price</label>
                                    <input type="number" name="oldPrice" wire:model="oldPrice" class="form-control" id="oldPrice">
                                    <small class="text-info">{{__('(Discount Price)')}}</small>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="d-flex justidy-content-between mb-4 col-12">
                                <h2 class="text-lg font-medium mr-auto">
                                    <b class="text-uppercase text-white">{{__('Upload Food Image')}}</b>
                                </h2>
                                <div class="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="img">Upload Image</label>
                                <input type="file" name="editFoodImg" id="editFoodImg" class="form-control" style="height: auto">
                                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                <div class="progress my-1">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated fImgEdit" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 d-flex justify-content-center mt-1">
                                    <img id="showEditFoodImg" class="img-thumbnail rounded" src="{{ $tempImg ? $tempImg : (app('cloudfront').$imgReader  ?: $emptyImg)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitJs">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>

