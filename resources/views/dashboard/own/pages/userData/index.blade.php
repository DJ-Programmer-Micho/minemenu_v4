@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.user-data-livewire')
</div>

@endsection