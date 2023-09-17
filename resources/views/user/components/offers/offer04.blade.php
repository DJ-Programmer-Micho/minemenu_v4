<div>
@if ($offerData)
<style>
    .place-body {
    border-radius: 15px 15px 0px 0px;
}
</style>
<div class="row offer-slider py-0 mb-4" style="margin-top: -15px">
    @if (count($offerData) > 1)
        @foreach ($offerData as $item)
        <div class="col-6 col-lg-6 px-1">
            <a href="{{url()->current()}}/offer/{{$item->id}}">
                <div class="offer-cat-item-02" style=" background-image: url('{{app('cloudfront').$item->img}}')">
                    <div class="offer-overlay-01">
                        <h4>{{$item->translation->name}}</h4>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    @else
        @foreach ($offerData as $item)
        <div class="col-12 px-1">
            <a href="{{url()->current()}}/offer/{{$item->id}}">
                <div class="offer-cat-item-02" style=" background-image: url('{{app('cloudfront').$item->img}}')">
                    <div class="offer-overlay-01">
                        <h4>{{$item->translation->name}}</h4>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    @endif
</div>
@endif
</div>