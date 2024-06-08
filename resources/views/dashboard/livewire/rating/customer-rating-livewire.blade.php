<div>
    <style>
        [lang = "ar"] .ar,
        [lang = "ku"] .ar
        {
            text-align: right;
            direction: rtl;
        }

    </style>
    {{-- <div class="badge-notification">
        <button type="button" data-toggle="modal" data-target="#addCustRate" class="rate-butt-detail-01">
            <i class="fas fa-star"></i>
        </button>
    </div> --}}
    <div wire:ignore.self class="modal fade overflow-auto" id="addCustRate" tabindex="-1" aria-labelledby="addCustRateLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-cart">
                <form wire:submit.prevent="">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title cart-title" id="addCustRateLabel">{{__('Sign Up')}}</h5>
                            <p>{{__('Sign Up So you can Rate!')}}</p>
                            <button type="button" type="button" class="btn cart-btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>

                        <div class="rating-form mt-3 ar">
                            <div class="form-group">
                                <label for="phone">{{ __('First Name') }}</label>
                                <input type="text" id="firstName" class="form-control w-100" wire:model="firstName">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Last Name') }}</label>
                                <input type="text" id="lastName" class="form-control w-100" wire:model="lastName">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Birth') }}</label>
                                <input type="date" id="birth" class="form-control w-100" wire:model="dob">
                            </div>
                            <div class="form-group text-left" dir="ltr">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" id="phone" class="form-control w-100" wire:model="phone">
                                <small>{{__('For Example')}} +964750</small>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="submitCustomerData" class="btn cart-btn-reset">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-modal', event => {
            $('#addCustRate').modal('hide');
        })
    </script>
</div>