<div class="food_item ">
    <div class="row my-1 p-0">
@forelse ($foodData as $item)
<div class="col-12 col-sm-6 p-1">
    <div class="slide shd h-100">
    <div class="food-img popup-gallery {{($item->old_price) ? 'offer' : ''}}">
         <a href="{{url()->current().'/'.$item->id}}"><img src="{{app('cloudfront'). $item->img}}"></a>

    </div>
    <div class="food-text">
         <div class="food-name">
                 <h5>{{$item->translation->name}}</h5>
         </div>
       
         <div class="food-desc">
                 <p class="m-0">{!! nl2br($item->translation->description) !!}</p>
         </div>
         @if (!$item->options)
            <div class="food-price">
                <span class="font-weight-bold h5">{{$item->price . ' ' .  $settings->currency}}</span>
                <span class="ml-2 old-price" style="text-decoration: line-through;font-size:17px;font-weight:bolder;padding-right: 10px">{{($item->old_price) ? $item->old_price : ''}}</span>
            </div>
         @endif
         <div class="add">
                @if ($item->options)
                    <button type="button" data-toggle="modal" data-target="#addlist_modal_Id" class="btn addItem addToList" data-name="{{ $item->name }}"
                        data-id="{{ $item->id }}" data-options="{{ $item->options }}"
                        data-img="{{app('cloudfront') . $item->img }}" data-price="{{ $item->price }}">
                        <i class="fa-solid fa-plus-minus"></i></button>
                @else
                    <button type="button" data-toggle="modal" data-target="#addlist_modal_Id" class="btn addItem addToList" data-name="{{ $item->name }}"
                        data-id="{{ $item->id }}" data-img="{{ app('cloudfront') . $item->img }}"
                        data-price="{{ $item->price }}"><i class="fa-solid fa-plus-minus"></i></button>
                @endif
        </div>
    </div>
    </div>
 </div>
 @empty
 <div class="text-center">Nothing To Show</div>
@endforelse
</div>
</div>