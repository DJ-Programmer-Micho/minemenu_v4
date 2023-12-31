<div class="row py-0 my-0">
    @forelse ($categoryData as $item)
    <div class="col-4 px-1 py-0">
        <a href="{{url()->current()}}/cat/{{$item->id}}">
            <div class="cat_item-01" style=" background-image: url('{{app('cloudfront').$item->img}}')">
                <div class="overlay-01">
                    <h4>{{$item->translation->name}}</h4>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 mt-5">
        <div class="text-center">{{__('Nothing To Show')}}</div>
    </div>
    @endforelse
    <x-business.CopyRight01Component/>
</div>