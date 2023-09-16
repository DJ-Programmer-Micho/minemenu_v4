@php
$options = json_decode($foodAction->options, true); // Decode the JSON options for the current item
$currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
@endphp
@if ($foodAction->sorm == 0)
<div class="col-md-12">
    <div class="row">
        <div class="col-6 mt-2">
            <h6 class="old-price-detail-01" style="text-decoration: line-through;">{{$foodAction->old_price . ' ' .  $settings->currency}}</h6>
            <h6 class="price-detail-01">{{$foodAction->price . ' ' .  $settings->currency}}</h6>
        </div>
        <div class="col-6">
            <div class="d-flex align-items-center justify-content-end">
                <button class="btn btn-sm btn-plus-minus" wire:click="decreaseQuantity('{{ $foodAction->id }}', 'null', 'null')">
                    <i class="fas fa-minus"></i>
                </button>
                <input class="form-control mx-2 text-center" type="number" min="1" max="10"
                    wire:model="quantity.{{ $foodAction->id }}"
                    value="{{ isset($quantity[$foodAction->id]) ? $quantity[$foodAction->id] : '0' }}"
                    wire:change="addToCart('{{ $foodAction->id }}','null','null')"
                />
                <button class="btn btn-sm btn-plus-minus" wire:click="increaseQuantity('{{ $foodAction->id }}', 'null', 'null')">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
    </div> {{-- Parent div --}}
    @else
    </div> {{-- Parent div --}}
    <div class="color-section">
        <div class="left">
            <h5 class="label choose-size-color">{{__('Choose Size')}}</h5>
            <hr>
            @foreach ($currentOptions as $index => $option)
            <div class="row mb-3" wire:key="{{ $index }}">
                <div class="col-6 my-auto">
                    <h6 class="food-price-value-01"><span class="font-weight-bold food-price-key-01">{{$option['key']}}</span> : {{$option['value'] . ' ' . $settings->currency}}</h6>
                </div>
                <div class="col-6">
                    <section class="text-white text-right ">
                        <div class="plus-minus border border-white">
                            <button class="btn btn-sm btn-plus-minus" wire:click="decreaseQuantity('{{ $foodAction->id }}', '{{ $option['key'] }}', '{{$index}}')">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input class="form-control mx-2 text-center" type="number" min="1" max="10"
                                wire:model="quantity.{{ $foodAction->id . '.' . $index .'.' . $option['key'] }}" 
                                value="{{ isset($previewQuantity[$foodAction->id][$index][$option['key']]) ? $previewQuantity[$foodAction->id][$index][$option['key']] : '0' }}"
                                wire:change="addToCart('{{ $foodAction->id }}','{{$option['key']}}','{{$index}}')"
                                 />
                            <button class="btn btn-sm btn-plus-minus" wire:click="increaseQuantity('{{ $foodAction->id }}', '{{ $option['key'] }}', '{{$index}}')">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </section>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endif

