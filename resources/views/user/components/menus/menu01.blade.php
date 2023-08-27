<div>
    <div>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @foreach ($menuData as $item)
            <li class="nav-item mb-2" role="presentation">
                <button class="nav-link {{$loop->index == 0 ? 'active' : ''}}" id="pills-{{$item->id}}-tab" data-toggle="pill" data-target="#pills-{{$item->id}}" type="button" role="tab" aria-controls="pills-{{$item->id}}" aria-selected="true">{{$item->translation->name}}</button>
            </li>
            @endforeach
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social"
                    type="button" role="tab" aria-controls="pills-social"
                    aria-selected="true">{{__("Follow Us")}}</button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="pills-tabContent">
        @foreach ($menuData as $menu)
        <div class="tab-pane fade {{$loop->index == 0 ? 'show active' : ''}}" id="pills-{{$menu->id}}" role="tabpanel"
            aria-labelledby="pills-{{$menu->id}}-tab">
            <x-business.category01component :menuid="$menu->translation->menu_id" :user="$user_id" :glang="$glang" :ui="$ui" />
        </div> 
        @endforeach
    </div>
</div>

{{-- wire:click="loadCategories({{ $item->id }})"  --}}