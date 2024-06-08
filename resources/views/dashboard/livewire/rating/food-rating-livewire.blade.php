<div>

    <style>
        [lang = "ar"] .ar,
        [lang = "ku"] .ar
        {
            text-align: right;
            direction: rtl;
        }

    </style>
    <div class="rating-form mt-3">
        <div class="form-group">
            <div id="foodSelectRating">
                @for ($i = 1; $i <= 5; $i++) 
                <i class="{{ $avg >= $i ? 'fas fa-star' : 'far fa-star' }} fa-star-stroke {{ $avg >= $i ? 'text-warning' : '' }}"
                    wire:click="foodSetRating('food', {{ $i }})"
                    style="cursor: pointer;"  
                    data-toggle="modal" 
                    data-target="#addFoodRate">
                </i>
                @endfor
                <span class="avgStare">{{$avg}} ({{ $review }})</span>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade overflow-auto" id="addFoodRate" tabindex="-1" aria-labelledby="addFoodRateLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 800px;">
            <div class="modal-content bg-cart">
                <form wire:submit.prevent="">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title cart-title ar" id="addFoodRateLabel">{{__('Rate Us')}}</h5>
                            <button type="button" type="button" class="btn cart-btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
    
                        <div class="rating-form mt-3 ar">
                            <div class="form-group">
                                <label for="foodRating">{{ __('Food Raiting') }}</label>
                                <div id="foodRating">
                                    @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star {{ $food >= $i ? 'text-warning' : '' }}"
                                        wire:click="foodSetRating('food', {{ $i }})" style="cursor: pointer;">
                                    </i>
                                    @endfor
                                    <span class="avgStare">{{$avg}} ({{ $review }})</span>
                                </div>
                            </div>

                            <div class="form-group text-left" dir="ltr">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="number" id="phone" class="form-control w-100" wire:model="phone" autocomplete="true" autocomplete="mobile">
                                <small>{{__('For Example')}} +964750</small>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="submitFoodRating" class="btn cart-btn-reset">{{__('Submit')}}</button>
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
                    $('#addFoodRate').modal('hide');
                });
                
                Livewire.on('showAddCustRateFoodModal', ($data) => {
                    Livewire.emit('sendData',$data);
                    $('#addCustRate').modal('show');
                });
    
    
    
                window.addEventListener('close-modal', event => {
                    $('#addFoodRate').modal('hide');
                })
            });
        </script>
</div>
