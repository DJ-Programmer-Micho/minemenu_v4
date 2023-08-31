<div>
<div class="badge-notification" data-count="{{$cart_count}}">
    <button data-toggle="modal" data-target="#checkCart" class="cart-butt-detail-01"><i class="fas fa-shopping-cart"></i></button>
</div>

<div wire:ignore.self class="modal fade overflow-auto" id="checkCart" tabindex="-1" aria-labelledby="checkCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
        <div class="modal-content bg-dark">
            <form wire:submit.prevent="">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkCartLabel">{{__('Add Food')}}</h5>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                    </div>

                    <table class="table table-dark">
                        <thead>
                          <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">QTY</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)     
                            @if ($item->options['sorm'] == 0)
                            <tr>
                                <td>
                                    <img src="{{ app('cloudfront') . $item->options['img'] }}"
                                    alt="Image"
                                    style="width: 78px; height: 78px; object-fit: cover; margin: auto;">                            
                                </td>
                                <td>
                                    {{$item->name[$glang]}}<br>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button class="btn btn-sm btn-dark" wire:click="decreaseQuantity('{{$item->id }}', 'null', 'null', {{$item->options['sorm']}})">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input class="form-control mx-2 text-center" type="number" min="1" max="10"
                                        wire:model="quantity.{{ $item->id }}"
                                        value="{{ isset($quantity[$item->id]) ? $quantity[$item->id] : '0' }}"
                                        wire:change="addToCart('{{ $item->id }}','null','null')"
                                    />
                                    <button class="btn btn-sm btn-dark" wire:click="increaseQuantity('{{ $item->id }}', 'null', 'null', {{$item->options['sorm']}})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    </div>
                                </td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->qty}}</td>
                              </tr>                                  
                              @else
                              <tr>
                                <td>
                                    <img src="{{ app('cloudfront') . $item->options['img'] }}"
                                    alt="Image"
                                    style="width: 78px; height: 78px; object-fit: cover; margin: auto;">                            
                                </td>
                                <td>
                                    {{$item->name[$glang]}}<br>
                                    <div class="plus-minus border border-white">
                                        <button class="btn btn-sm btn-dark" wire:click="decreaseQuantity('{{$item->id }}', '{{ $item->options['size'] }}', '{{ $item->options['sizeindex']}}',{{$item->options['sorm']}})">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input class="form-control mx-2 text-center" type="number" min="1" max="10"
                                        wire:model="quantity.{{$item->id . '.' .  $item->options['sizeindex'] .'.' .$item->options['size'] }}" 
                                        value="{{ isset($quantity[$item->id][$item->options['sizeindex']][$item->options['size']]) ? $quantity[$item->id][$item->options['sizeindex']][$item->options['size']] : '0' }}"
                                        wire:change="addToCart('{{$item->id }}','{{ $item->options['size']}}','{{ $item->options['sizeindex']}}')"
                                         />
                                         <button class="btn btn-sm btn-dark" wire:click="increaseQuantity('{{$item->id }}', '{{ $item->options['size'] }}', '{{ $item->options['sizeindex']}}',{{$item->options['sorm']}})">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->qty}}</td>
                              </tr>

                            @endif  

                          @endforeach
                        </tbody>
                      </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>