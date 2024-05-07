<div class="mt-4">
    <form wire:submit.prevent="saveSettings">
        <h3 class="text-white">{{__('Menu Setting')}}</h3>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="mb-3">
                    <label class="text-white">{{__('Resturant Phone Number')}}</label>
                    <input type="text" wire:model="phone" class="form-control">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Resturant Phone Number 2')}}</label>
                    <input type="text" wire:model="phone_two" class="form-control">
                    @error('phone_two') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('WIFI Password')}}</label>
                    <input type="text" wire:model="wifi" class="form-control">
                    @error('wifi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Currency ($,€, IQD, دينار)')}}</label>
                    <input type="text" wire:model="currency" class="form-control">
                    @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white">{{__('Fees %')}}</label>
                    <input type="number" wire:model="fees" class="form-control">
                    @error('fees') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @foreach ($filteredLocales as $locale)
                <div class="mb-3">
                    <label class="text-white">{{__('Note:')}} {{ __(strtoupper($locale)) }}</label>
                    <input type="text" wire:model="notes.{{$locale}}" class="form-control"
                        style="{{$locale == "ar" || $locale == 'ku' ? "direction: rtl;" : ""}}" placeholder="Example: 10% Taxes"> 
                    @error('notes.'.$locale) <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endforeach
                <div class="border p-1">

                    <div class="mb-3">
                        <label class="text-white"><i class="fas fa-shopping-cart mr-1"></i>{{__('View Cart')}}</label>
                        <select class="form-control" name="cart_status" wire:model="cart_status">
                            <option value="0" default>{{__('Non-Active')}}</option>
                            <option value="1">{{__('Active')}}</option>
                        </select>
                        @error('cart_status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="mb-3">
                    <label class="text-white"><i class="fas fa-globe mr-1"></i>{{__('Website URL')}}</label>
                    <input type="text" wire:model="website" class="form-control" placeholder="https://minemenu.com/">
                    @error('website') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fab fa-facebook mr-1"></i>{{__('Facebook URL')}}</label>
                    <input type="text" wire:model="facebook" class="form-control" placeholder="https://www.facebook.com/minemenuiq">
                    @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fab fa-instagram mr-1"></i>{{__('Instagram URL')}}</label>
                    <input type="text" wire:model="instagram" class="form-control" placeholder="https://www.instagram.com/minemenuiq/">
                    @error('instagram') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fab fa-telegram mr-1"></i>{{__('Telegram URL')}}</label>
                    <input type="text" wire:model="telegram" class="form-control" placeholder="https://t.me/minemenuiraq">
                    @error('telegram') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fab fa-snapchat mr-1"></i>{{__('Snapchat URL')}}</label>
                    <input type="text" wire:model="snapchat" class="form-control" placeholder="https://t.snapchat.com/YOUR-ID">
                    @error('snapchat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fab fa-tiktok mr-1"></i>{{__('TikTok URL')}}</label>
                    <input type="text" wire:model="tiktok" class="form-control" placeholder="https://www.tiktok.com/YOUR-ID">
                    @error('tiktok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-white"><i class="fas fa-map-marker-alt mr-1"></i>{{__('Map URL')}}</label>
                    <input type="text" wire:model="map" class="form-control" placeholder="https://maps.app.goo.gl/YOUR-ID">
                    @error('map') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="border p-1">

                    <div class="mb-3">
                        <label class="text-white"><i class="fab fa-telegram-plane mr-1"></i>{{__('Telegram Channel Status')}}</label>
                        <select class="form-control" name="telegram_notify_status" wire:model="telegram_notify_status">
                            <option value="0" default>{{__('Non-Active')}}</option>
                            <option value="1">{{__('Active')}}</option>
                        </select>
                        @error('telegram_notify_status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="text-white"><i class="fab fa-telegram-plane mr-1"></i>{{__('Telegram Channel URL')}}</label>
                        <input type="text" wire:model="telegram_notify" class="form-control">
                        @error('telegram_notify') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="m-3">

                <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
            </div>
        </div>
    </form>
</div>