@extends('user.index.ui-1.layouts.layout')
@push('business_style')
    <style>
        .cat_item_S {
            height: 110px;
            min-width: 110px;
            max-width: 140px;
            border-radius: 18px;
            margin-top: 15px;
            background-position: 50%;
            background-size: cover;
            overflow: hidden;
        }
        .overlay_S {
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            text-align: center;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

    </style>
@endpush
@section('business-content')

{{-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="true">{{__("Follow Us")}}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="true">{{__("Follow Us")}}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="true">{{__("Follow Us")}}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-social-tab" data-toggle="pill" data-target="#pills-social" type="button" role="tab" aria-controls="pills-social" aria-selected="true">{{__("Follow Us")}}</button>
    </li>
</ul> --}}


<div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade "  role="tabpanel">
            <livewire:user.components.cat01-component :restName="$data"/>
        </div>
</div>


@endsection