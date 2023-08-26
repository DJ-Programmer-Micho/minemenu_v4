<div>
    <div>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" wire:ignore>
        @foreach ($menuDataC as $item)
        <li class="nav-item mb-2" role="presentation">
            <button  wire:click="loadCategories({{ $item->id }})" class="nav-link {{$loop->index == 0 ? 'active' : ''}}" id="pills-{{$item->id}}-tab" data-toggle="pill" data-target="#pills-{{$item->translation->name}}" type="button" role="tab" aria-controls="pills-{{$item->id}}" aria-selected="true">{{$item->translation->name}}</button>
        </li>
        @endforeach
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="true">{{__("Follow Us")}}</button>
        </li>
    </ul>
</div>

<div class="tab-content" id="pills-tabContent">
    @foreach ($menuDataC as $menu)
    <div class="tab-pane fade {{$loop->index == 0 ? 'show active' : ''}}" id="pills-{{$menu->id}}"  role="tabpanel"
        aria-labelledby="pills-{{$menu->id}}-tab">
        @livewire('user.components.category'.$aaa.'-livewire', [
            'menuId' =>  $menu->translation->menu_id,
            'user' => $user_id,
            'glang' => $glang 
            ], key('category-'.$menu->id))
        </div>
        @endforeach
@php
    $sss = '01';
@endphp
        {{-- @include('components.testt' . $sss) --}}
        @if ($sss == '01')
            
        <x-business.testt01/>
        @else
        <x-business.testt02/>
            
        @endif
    </div>

   
</div>