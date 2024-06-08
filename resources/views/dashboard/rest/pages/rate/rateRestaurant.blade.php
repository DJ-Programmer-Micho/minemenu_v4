@extends('dashboard.rest.layouts.layout')
@section('tail','Food')
@section('rest_content')

@php
    $categorieFilter = ''; // Initialize $categorieFilter with a default value
@endphp
<div>
    {{-- @livewire('dashboard.rate-restaurant-livewire', ['key' => $categorieFilter]) --}}
    @livewire('dashboard.rate-restaurant-livewire')
</div>

@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createFood').modal('hide');
        $('#updateFoodModal').modal('hide');
        $('#deleteFoodModal').modal('hide');
    }) 
</script>
@endsection