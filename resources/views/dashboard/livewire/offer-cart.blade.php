@php
$currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
@endphp
<div class="col-md-12">
    <div class="row">
        <div class="col-6 mt-2">
            <h6 class="old-price-detail-01" style="text-decoration: line-through;">{{($offerAction->old_price) ? $offerAction->old_price .' '.$settings->currency : ''}}</h6>
            <h6 class="price-detail-01">{{$offerAction->price . ' ' .  $settings->currency}}</h6>
        </div>
        <div class="col-6">
            <div class="d-flex align-items-center justify-content-end price-box">
                <button class="btn btn-sm btn-dark" wire:click="decreaseQuantity('{{ $offerAction->id }}', 'null', 'null')">
                    <i class="fas fa-minus"></i>
                </button>
                <input class="form-control mx-2 text-center" type="number" min="1" max="10"
                    wire:model="quantity.{{ $offerAction->id }}"
                    value="{{ isset($quantity[$offerAction->id]) ? $quantity[$offerAction->id] : '0' }}"
                    wire:change="addToCart('{{ $offerAction->id }}','null','null')"
                />
                <button class="btn btn-sm btn-dark" wire:click="increaseQuantity('{{ $offerAction->id }}', 'null', 'null')">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>


