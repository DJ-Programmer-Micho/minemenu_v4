<div>
    <style>
        [lang = "ar"] .ar,
        [lang = "ku"] .ar
        {
            text-align: right;
            direction: rtl;
        }

    </style>
    <div class="badge-notification">
        <button type="button" data-toggle="modal" data-target="#addRestRate" class="rate-butt-detail-01">
            <i class="fas fa-star"></i>
        </button>
    </div>
    <div wire:ignore.self class="modal fade overflow-auto" id="addRestRate" tabindex="-1" aria-labelledby="addRestRateLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-cart">
                <form wire:submit.prevent="">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title cart-title" id="addRestRateLabel">{{__('Rate Us')}}</h5>
                            <button type="button" type="button" class="btn cart-btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
    

                        <div class="rating-form mt-3 ar">
                            <div class="form-group">
                                <label for="staffRating">{{ __('Staff') }}</label>
                                <div id="staffRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $staff >= $i ? 'text-warning' : '' }}" wire:click="setRating('staff', {{ $i }})" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="serviceRating">{{ __('Service') }}</label>
                                <div id="serviceRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $service >= $i ? 'text-warning' : '' }}" wire:click="setRating('service', {{ $i }})" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="environmentRating">{{ __('Environment') }}</label>
                                <div id="environmentRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $environment >= $i ? 'text-warning' : '' }}" wire:click="setRating('environment', {{ $i }})" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="experienceRating">{{ __('Experience') }}</label>
                                <div id="experienceRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $experience >= $i ? 'text-warning' : '' }}" wire:click="setRating('experience', {{ $i }})" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cleaningRating">{{ __('Cleaning') }}</label>
                                <div id="cleaningRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $cleaning >= $i ? 'text-warning' : '' }}" wire:click="setRating('cleaning', {{ $i }})" style="cursor: pointer;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Note') }}</label>
                                <textarea id="note" class="form-control w-100" wire:model="note" rows="3"></textarea>
                            </div>
                            <div class="form-group text-left" dir="ltr">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="number" id="phone" class="form-control w-100" wire:model="phone">
                                <small>{{__('For Example')}} +964750</small>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="submitRestRating" class="btn cart-btn-reset">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @livewire('rating.customer-data-rating-livewire', [
        'glang' => app()->getLocale(),
        ])
 
    <script>
        document.addEventListener('livewire:load', function () {
            // Listen for the Livewire event and show the modal
            Livewire.on('hideRate', () => {
                $('#addRestRate').modal('hide');
            });
            
            Livewire.on('showAddCustRateModal', ($data) => {
                Livewire.emit('sendData',$data);
                $('#addCustRate').modal('show');
            });

            window.addEventListener('close-modal', event => {
                $('#addRestRate').modal('hide');
            })
        });
    </script>

</div>