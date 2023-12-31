<div>
    <div class="mt-4">
        <form wire:submit.prevent="saveSettings">
            <h3 class="text-white">{{__('Resturant Name Setting')}}</h3>
            <hr class="bg-white">
            <div class="row">
              
                @forelse ($filteredLocales as $locale)
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label>{{__('Resturant Name')}} {{ strtoupper($locale) }}</label>
                        <input type="text" wire:model="namesData.{{$locale}}" class="form-control"
                            style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                        @error('namesData.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label>{{__('Resturant Address')}} {{ strtoupper($locale) }}</label>
                        <input type="text" wire:model="addressData.{{$locale}}" class="form-control"
                            style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                        @error('addressData.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                @empty
                <h1>{{__('Error Please Contact the Support')}}</h1>
                @endforelse
            </div>
            <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </form>
    </div>
</div>
