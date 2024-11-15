<div class="food_item-01" style="margin-top: -5px">
    <div class="row px-1">
        @forelse ($foodData as $item)
        @php
        $options = json_decode($item->options, true); // Decode the JSON options for the current item
        $currentOptions = $options[$glang] ?? []; // Get options for the current language or default to an empty array
        @endphp
        <div class="col-7 px-0 card-01 shd-01">
            <div class="text-section-03">
                <div class="food-text-01">
                    <div class="food-name-01">
                        <h5>{{$item->translation->name}}</h5>
                    </div>

                    @if ($item->sorm == 0)
                    <div class="food-price-01 d-flex">
                        <div class="font-weight-bold h6">{{number_format($item->price) . ' ' .  $settings->currency}}</div>
                        <div class="ml-2 old-price-01" style="text-decoration: line-through;font-size:17px;font-weight:bolder;padding-right: 10px">{{($item->old_price) ? $item->old_price . ' ' .  $settings->currency : ''}}</div>
                    </div>
                    <div>
                        @for ($i = 1; $i <= 5; $i++) 
                        <a href="{{url()->current().'/'.$item->id}}">
                        <i class="{{  number_format($item->food_ratings_avg_rating, 1) >= $i ? 'fas fa-star' : 'far fa-star' }} fa-star-stroke {{number_format($item->food_ratings_avg_rating, 1) >= $i ? 'text-warning' : '' }}"></i>
                        </a>
                        @endfor
                        <span class="avgStare">{{number_format($item->food_ratings_avg_rating, 1)}} ({{ $item->food_ratings_count }})</span>
                    </div>
                        <span><a href="{{url()->current().'/'.$item->id}}" class="btn btn-see-more">{{__('See More Details')}}</a></span>
                    <div>
                       
                    </div>
                    @else
                    @foreach ($currentOptions as $option)
                    <div class="food-price-01 options-price">
                        <div class="font-weight-bold h6"> {{$option['key']}}: {{ number_format($option['value']) }} {{$settings->currency}}</div>
                    </div>
                    @endforeach
                    <div>
                        @for ($i = 1; $i <= 5; $i++) 
                        <a href="{{url()->current().'/'.$item->id}}">
                        <i class="{{  number_format($item->food_ratings_avg_rating, 1) >= $i ? 'fas fa-star' : 'far fa-star' }} fa-star-stroke {{number_format($item->food_ratings_avg_rating, 1) >= $i ? 'text-warning' : '' }}"></i>
                        </a>
                        @endfor
                        <span class="avgStare">{{number_format($item->food_ratings_avg_rating, 1)}} ({{ $item->food_ratings_count }})</span>
                    </div>
                    <span><a href="{{url()->current().'/'.$item->id}}" class="btn btn-see-more">{{__('See More Details')}}</a></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-5 px-0 card-01 shd-01 d-flex align-items-center">
                @if ($item->special == 1)
                <img class="special_card-03" class="responsive-img" src="{{asset('assets/main/img/special.gif')}}" alt="minemenu_special">
                @endif
                <div class="food-img-03 my-auto {{($item->old_price) ? 'offer' : ''}}">
                    <a href="{{url()->current().'/'.$item->id}}"><img src="{{app('cloudfront'). $item->img}}"></a>
                </div>
        </div>
        @empty
        <div class="text-center">{{__('Nothing To Show')}}</div>
        @endforelse
        <x-business.CopyRight01Component/>
    </div>
</div>
</div>
