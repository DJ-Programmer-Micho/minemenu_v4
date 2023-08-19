@extends('dashboard.rest.layouts.layout')
@section('tail','Food')
@section('rest_content')

<div>
    @livewire('dashboard.menu-setting-livewire')
</div>


@endsection
@section('rest_script')
{{-- <script>
    window.addEventListener('close-modal', event => {
        $('#createFood').modal('hide');
        $('#updateFoodModal').modal('hide');
        $('#deleteFoodModal').modal('hide');
    })
</script> --}}
@endsection