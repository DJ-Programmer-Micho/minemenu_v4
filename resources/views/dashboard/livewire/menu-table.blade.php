<!-- Insert Modal -->
<div wire:ignore.self class="modal fade overflow-auto" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">{{__('Add Menu')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                    wire:click="closeModal">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
            </div>
            <form wire:submit.prevent="saveMenu">
                <div class="modal-body">
                    <h3>{{__('Menu Name')}}</h3>
                <div class="row">
                    <div class="col-12 col-md-6">
                            @foreach ($filteredLocales as $locale)
                            <div class="mb-3">
                                <label>{{__('Menu Name in')}} {{ __(strtoupper($locale))}}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                        </div>
                  
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label>{{__('Status')}}</label>
                            <select wire:model="status" name="status" id="" class="form-control">
                                <option value="">{{__('Choose Status')}}</option>
                                <option value="1">{{__('Active')}}</option>
                                <option value="0">{{__('Non Active')}}</option>
                            </select>
                            <small class="bg-info text-white px-2 rounded"><b>{{__('Active or non-active / Show or Hide')}}</b></small>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    <div class="mb-3">
                        <label>{{__('Priority')}}</label>
                        <input type="number" wire:model="priority" class="form-control">
                        <small class="bg-info text-white px-2 rounded"><b>{{__('The less The Higher Priority')}}</b></small>
                        @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Update Student Modal -->
<div wire:ignore.self class="modal fade" id="updatemenuModal" tabindex="-1" aria-labelledby="updatemenuModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="updatemenuModalLabel">{{__('Edit Menu')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="updateMenu">
                <div class="modal-body">
                    <h3>{{__('Menu Name')}}</h3>
                <div class="row">
                    <div class="col-12 col-md-6">
                            @foreach ($filteredLocales as $locale)
                            <div class="mb-3">
                                <label>{{__('Menu Name in')}} {{ __(strtoupper($locale))}}</label>
                                <input type="text" wire:model="names.{{$locale}}" class="form-control"
                                    style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                                @error('names.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                        </div>
                  
                    <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label>{{__('Status')}}</label>
                        <select wire:model="status" name="status" id="" class="form-control">
                            <option value="">{{__('Choose Status')}}</option>
                            <option value="1">{{__('Active')}}</option>
                            <option value="0">{{__('Non Active')}}</option>
                            <small class="bg-info text-white px-2 rounded">{{__('Active or non-active / Show or Hide')}}</small>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>{{__('Priority')}}</label>
                        <input type="number" wire:model="priority" class="form-control">
                        <small class="bg-info text-white px-2 rounded">{{__('The less The Higher Priority')}}</small>
                        @error('Priority') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
 
<!-- Delete Student Modal -->
<div wire:ignore.self class="modal fade" id="deletemenuModal" tabindex="-1" aria-labelledby="deletemenuModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deletemenuModalLabel">{{__('Delete Menu')}}</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form wire:submit.prevent="destroyMenu">
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this Menu?') }}</p>
                    <p>{{ __('Please enter the')}}<strong> "{{$showTextTemp}}" </strong>{{__('to confirm:') }}</p>
                    <input type="text" wire:model="menuNameToDelete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || menuNameToDelete !== $showTextTemp">
                            {{ __('Yes! Delete') }}
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
