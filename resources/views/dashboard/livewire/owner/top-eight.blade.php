<div class="mt-4">
    <form wire:submit.prevent="saveMenuShow">
        <h3 class="text-white">{{__('Menu Setting')}}</h3>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="showMenu" class="text-white">{{__('Give 8 ID of menus')}}</label>
                    <input type="text" name="showMenu" wire:model="showMenu" class="form-control">
                    <small class="text-white">Example (1,2,3)</small>
                    @error('showMenu') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="m-3">
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
            </div>
        </div>
    </form>
</div>