@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.dynamic-url-livewire')
</div>
@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createAd').modal('hide');
        $('#updateAdModal').modal('hide');
        $('#deleteAdModal').modal('hide');
    }) 
</script>
@endsection
