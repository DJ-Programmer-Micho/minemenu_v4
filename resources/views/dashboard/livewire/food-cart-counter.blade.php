<div>
{{-- @if (app('viewCart')) --}}
<i class="fa fa-cart"></i>
<div class="badge-notification" data-count="{{$cart_count}}">
    <button type="button" data-toggle="modal" data-target="#checkCart" class="cart-butt-detail-01"><i class="fas fa-shopping-cart"></i></button>
</div>
<div wire:ignore.self class="modal fade overflow-auto" id="checkCart" tabindex="-1" aria-labelledby="checkCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-cart">
            <form wire:submit.prevent="">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title cart-title" id="checkCartLabel">{{__('Cart')}}</h5>
                        <button type="button" type="button" class="btn cart-btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>

                    @if(count($cart) === 0)
                    <h3 class="text-center">{{__('Nothing To Show')}}</h3>
                    @else
                   
                       
                        <table class="table table-cart table-sm">
                            <thead>
                                <tr>
                                    <th scope="col"><small>Image</small></th>
                                    <th scope="col"><small>Name</small></th>
                                    <th scope="col" class="text-center"><small>Unit Price</small></th>
                                    <th scope="col" class="text-center"><small>QTY</small></th>
                                    <th scope="col" class="text-center"><small>Total</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <p class="text-white">{{$cart}}</p> --}}
                        @foreach ($cart as $item) 
                             @if($item->options['size'] != 'offer')
                                @if ($item->options['sorm'] == 0)
                                <tr>
                                    <td>
                                        <img src="{{ app('cloudfront') . $item->options['img'] }}"
                                        alt="Image"
                                        style="width: 68px; height: 68px; object-fit: cover; margin: auto;">                            
                                    </td>
                                    <td>
                                        {{$item->name[$glang]}}<br>
                                        <div class="plus-minus border border-white">
                                            <button type="button" class="btn btn-sm plus-minus-color" wire:click="decreaseQuantity('{{$item->id }}', 'null', 'null', {{$item->options['sorm']}})">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input class="form-control mx-2 text-center" type="number" min="1" max="10" style="background-color: transparent;"
                                            wire:model="quantity.{{ $item->id }}"
                                            value="{{ isset($quantity[$item->id]) ? $quantity[$item->id] : '0' }}"
                                            wire:change="addToCart('{{ $item->id }}','null','null')"
                                        />
                                            <button type="button" class="btn btn-sm plus-minus-color" wire:click="increaseQuantity('{{ $item->id }}', 'null', 'null', {{$item->options['sorm']}})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$item->price}} {{$currency}}</td>
                                    <td class="text-center">{{$item->qty}}</td>
                                    <td class="text-center">{{floatval($item->subtotal)}} {{$currency}}</td>

                                </tr>                                  
                                <tr>
                                    <td>
                                        {{-- <button class="btn btn-sm btn-danger" wire:click="removeFood('{{$item->rowId }}')">{{__('Remove')}}</button> --}}
                                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeFood('{{$item->rowId }}','{{$item->id }}', 'null', 'null')">{{__('Remove')}}</button>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>
                                        <img src="{{ app('cloudfront') . $item->options['img'] }}"
                                        alt="Image"
                                        style="width: 68px; height: 68px; object-fit: cover; margin: auto;">                            
                                    </td>
                                    <td>
                                        {{$item->name[$glang]}}<br>
                                        <div class="plus-minus border border-white">
                                            <button type="button" class="btn btn-sm plus-minus-color" wire:click="decreaseQuantity('{{$item->id }}', '{{ $item->options['size'] }}', '{{ $item->options['sizeindex']}}',{{$item->options['sorm']}})">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input class="form-control mx-2 text-center" type="number" min="1" max="10" style="background-color: transparent;
                                            wire:model="quantity.{{$item->id . '.' .  $item->options['sizeindex'] .'.' .$item->options['size'] }}" 
                                            value="{{ isset($quantity[$item->id][$item->options['sizeindex']][$item->options['size']]) ? $quantity[$item->id][$item->options['sizeindex']][$item->options['size']] : '0' }}"
                                            wire:change="addToCart('{{$item->id }}','{{ $item->options['size']}}','{{ $item->options['sizeindex']}}')"
                                            />
                                            {{-- <button class="btn btn-sm btn-dark" wire:click="increaseQuantity('{{$item->id }}')"> --}}
                                            <button type="button" class="btn btn-sm plus-minus-color" wire:click="increaseQuantity('{{$item->id }}', '{{ $item->options['size'] }}', '{{ $item->options['sizeindex']}}',{{$item->options['sorm']}})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$item->price}} {{$currency}}</td>
                                    <td class="text-center">{{$item->qty}}</td>
                                    <td class="text-center">{{floatval($item->subtotal)}} {{$currency}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeFood('{{$item->rowId }}', '{{$item->id }}', '{{ $item->options['size'] }}', '{{ $item->options['sizeindex']}}')">{{__('Remove')}}</button>
                                    </td>
                                </tr>
                                @endif  
                        
                            @else
                            
                            <tr>
                                <td>
                                    <img src="{{ app('cloudfront') . $item->options['img'] }}"
                                    alt="Image"
                                    style="width: 68px; height: 68px; object-fit: cover; margin: auto;">                            
                                </td>
                                <td>
                                    {{$item->name[$glang]}}<br>
                                    <div class="plus-minus border border-white">
                                        <button type="button" class="btn btn-sm plus-minus-color" wire:click="decreaseOfferQuantity('{{$item->id }}', 'null', 'null', 'null')">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input class="form-control mx-2 text-center" type="number" min="1" max="10" style="background-color: transparent;"
                                        wire:model="quantityOffer.{{ $item->id }}"
                                        value="{{ isset($quantityOffer[$item->id]) ? $quantityOffer[$item->id] : '0' }}"
                                        wire:change="addToCartOffer('{{ $item->id }}','null','null')"
                                    />
                                        <button type="button" class="btn btn-sm plus-minus-color" wire:click="increaseOfferQuantity('{{ $item->id }}', 'null', 'null', 'null')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">{{$item->price}} {{$currency}}</td>
                                <td class="text-center">{{$item->qty}}</td>
                                <td class="text-center">{{floatval($item->subtotal)}} {{$currency}}</td>

                            </tr> 
                            <tr>
                                <td>
                                    {{-- <button class="btn btn-sm btn-danger" wire:click="removeFood('{{$item->rowId }}')">{{__('Remove')}}</button> --}}
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeFood('{{$item->rowId }}', 'null', 'null', 'null')">{{__('Remove')}}</button>
                                </td>
                            </tr>
                            @endif
                 
                        @endforeach
                        </tbody>
                      </table>
                      <div class="mt-2"></div>
                      <hr style="background-color: var(--theme-color);">
                      <p class="my-0 py-0 cart-text-color">Tax: %{{$tax}}</p>
                      <p class="my-0 py-0 cart-text-color">Total: {{$totalSubtotal}} {{$currency}}</p>
                      <p class="my-0 py-0 cart-text-color">-------</p>
                      <p class="cart-text-color">Grand Total: {{$grandTotal}} {{$currency}}</p>

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="removeList()" class="btn cart-btn-reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- @endif --}}
</div>