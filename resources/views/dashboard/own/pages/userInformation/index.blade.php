@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.user-information-livewire')
</div>

@endsection