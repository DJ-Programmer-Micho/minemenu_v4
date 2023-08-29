{{-- <div wire:ignore.self class="modal fade overflow-auto" id="addCart" tabindex="-1" aria-labelledby="addCart:abel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="saveFood">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createFoodLabel">{{__('Add Food')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        {{$hi->translation->name}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@php
$options = json_decode($foodAction->options, true); // Decode the JSON options for the current item
$currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
// dd( isset($quantity[$foodAction->id]));
// dd(  $zero);
@endphp
<form wire:submit.prevent="addToCart({{ $foodAction->id }})">
@if ($foodAction->sorm == 0)
    <div class="col-md-12 text-right">
        <div class="row">
            <div class="col-6 text-left">
                <h6 class="price-detail-01">{{$foodAction->price . ' ' .  $settings->currency}}</h6>
            </div>
            <div class="col-6">
                <section class="text-white">
                    <div class="plus-minus">
                        <i class="fas fa-plus" wire:click="increaseQuantity('{{ $foodAction->id }}')"></i>
                        <input type="number" 
                         min="1" max="10"
                         wire:model="quantity.{{ $foodAction->id }}"
                         value="{{ isset($quantity[$foodAction->id]) ? $quantity[$foodAction->id] : '0' }}"
                         wire:change="addToCart('{{ $foodAction->id }}')"
                        />
                        <i class="fas fa-minus" wire:click="decreaseQuantity('{{ $foodAction->id }}')"></i>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div> {{-- Parent div --}}
    @else
    </div> {{-- Parent div --}}
    <div class="color-section">
        <div class="left">
            <h5 class="label">{{__('Choose Size')}}</h5>
            <hr>
            @foreach ($currentOptions as $option)
            <div class="row mb-3">
                <div class="col-6 my-auto">
                    <h6><span class="font-weight-bold ">{{$option['key']}}</span> : {{$option['value'] . ' ' . $settings->currency}}</h6>
                </div>
                <div class="col-6">
                    <section class="text-white text-right ">
                        <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus"></i></button>
                        <div class="plus-minus border border-white">
                            <i class="fas fa-minus"></i>
                            <input type="number"
                                wire:model="quantity.{{$option['key'] .'.'. $foodAction->id }}" min="1"
                                max="10" />
                            <i class="fas fa-plus"></i>
                        </div>
                    </section>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</form>
@endif
