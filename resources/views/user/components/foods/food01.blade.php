<div class="food_item-01">
    <div class="row my-1 p-0">
        @forelse ($foodData as $item)
        @php
        $options = json_decode($item->options, true); // Decode the JSON options for the current item
        $currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
        $itemDescription = $item->translation->description; 
        if (strlen($itemDescription) > 120) {
            $trimmedDescription = substr($itemDescription, 0, 120);
            $lastLineBreak = strrpos($trimmedDescription, "\n");
            if ($lastLineBreak !== false) {
                $trimmedDescription = substr($trimmedDescription, 0, $lastLineBreak);
            }
            $trimmedDescription .= '...';
        } else {
            $trimmedDescription = $itemDescription;
        }
        @endphp
        <div class="col-12 col-sm-6 p-1">
            <div class="card-01 shd-01 h-100">
                <div class="food-img-01 {{($item->old_price) ? 'offer' : ''}}">
                    <a href="{{url()->current().'/'.$item->id}}"><img src="{{app('cloudfront'). $item->img}}"></a>
                </div>
                <div class="food-text-01">
                    <div class="food-name-01">
                        <h5>{{$item->translation->name}}</h5>
                    </div>

                    <div class="food-desc-01">
                        <p class="m-0">{!! nl2br($trimmedDescription) !!}</p>
                    </div>
                    @if ($item->sorm == 0)
                    <div class="food-price-01">
                        <span class="font-weight-bold h5">{{$item->price . ' ' .  $settings->currency}}</span>
                        <span class="ml-2 old-price-01"
                            style="text-decoration: line-through;font-size:17px;font-weight:bolder;padding-right: 10px">{{($item->old_price) ? $item->old_price : ''}}</span>
                        </div>
                        <span><a href="{{url()->current().'/'.$item->id}}" class="btn btn-info">See More Details</a></span>
                    <div>
                       
                    </div>
                    @else
                    @foreach ($currentOptions as $option)
                    {{-- <span class="font-weight-bold h5">{{ $option['value'] . ' ' . $settings->currency }}</span> --}}
                    <!-- Add more elements as needed -->
                    <div class="food-price-01">
                        <span class="font-weight-bold h5">{{$option['key'].': '. $option['value'] . ' ' . $settings->currency }}</span>
                        <span class="ml-2 old-price-01"
                        style="text-decoration: line-through;font-size:17px;font-weight:bolder;padding-right: 10px">{{($item->old_price) ? $item->old_price : ''}}</span>
                    </div>
                    @endforeach
                    @endif
                    {{-- <div class="add">
                        @if ($item->options)
                        <button type="button" data-toggle="modal" data-target="#addlist_modal_Id"
                            class="btn addItem addToList" data-name="{{ $item->name }}" data-id="{{ $item->id }}"
                            data-options="{{ $item->options }}" data-img="{{app('cloudfront') . $item->img }}"
                            data-price="{{ $item->price }}">
                            <i class="fa-solid fa-plus-minus"></i></button>
                        @else
                        <button type="button" data-toggle="modal" data-target="#addlist_modal_Id"
                            class="btn addItem addToList" data-name="{{ $item->name }}" data-id="{{ $item->id }}"
                            data-img="{{ app('cloudfront') . $item->img }}" data-price="{{ $item->price }}"><i
                                class="fa-solid fa-plus-minus"></i></button>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
        @empty
        <div class="text-center">Nothing To Show</div>
        @endforelse
    </div>
</div>
