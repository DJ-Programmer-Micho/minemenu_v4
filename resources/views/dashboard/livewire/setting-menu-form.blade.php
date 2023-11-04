<div class="mt-4">
    <form wire:submit.prevent="saveSettings">
        <h3 class="text-white">{{__('Menu Setting')}}</h3>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="mb-3">
                    <label class="text-white">{{__('Phone')}}</label>
                    <input type="text" wire:model="phone" class="form-control">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('WIFI')}}</label>
                    <input type="text" wire:model="wifi" class="form-control">
                    @error('wifi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Currency')}}</label>
                    <input type="text" wire:model="currency" class="form-control">
                    @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Fees')}}</label>
                    <input type="number" wire:model="fees" class="form-control">
                    @error('fees') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @foreach ($filteredLocales as $locale)
                <div class="mb-3">
                    <label class="text-white">{{ strtoupper($locale) }}</label>
                    <input type="text" wire:model="notes.{{$locale}}" class="form-control"
                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}">
                    @error('notes.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endforeach
            </div>
            <div class="col-12 col-sm-6">
                <div class="mb-3">
                    <label class="text-white">{{__('Website URL')}}</label>
                    <input type="text" wire:model="website" class="form-control">
                    @error('website') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Facebook URL')}}</label>
                    <input type="text" wire:model="facebook" class="form-control">
                    @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Instagram URL')}}</label>
                    <input type="text" wire:model="instagram" class="form-control">
                    @error('instagram') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Telegram URL')}}</label>
                    <input type="text" wire:model="telegram" class="form-control">
                    @error('telegram') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Snapchat URL')}}</label>
                    <input type="text" wire:model="snapchat" class="form-control">
                    @error('snapchat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('TikTok URL')}}</label>
                    <input type="text" wire:model="tiktok" class="form-control">
                    @error('tiktok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Map URL')}}</label>
                    <input type="text" wire:model="map" class="form-control">
                    @error('map') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="border p-1">

                    <div class="mb-3">
                        <label class="text-white">{{__('Telegram Channel Status')}}</label>
                        <select class="form-control" name="telegram_notify_status" wire:model="telegram_notify_status">
                            <option value="0" default>{{__('Non Active')}}</option>
                            <option value="1">{{__('Active')}}</option>
                        </select>
                        @error('telegram_notify_status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="text-white">{{__('Telegram Channel URL')}}</label>
                        <input type="text" wire:model="telegram_notify" class="form-control">
                        @error('telegram_notify') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="m-3">

                <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>