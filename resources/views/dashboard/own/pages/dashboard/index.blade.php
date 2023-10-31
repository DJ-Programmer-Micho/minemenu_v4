@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.dashboardlivewire')
</div>

@endsection