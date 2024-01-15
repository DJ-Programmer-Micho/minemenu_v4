@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.dynamic-url-track-livewire')
</div>
@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createAdTrack').modal('hide');
        $('#updateAdTrack').modal('hide');
        $('#deleteAdTrack').modal('hide');
    }) 
</script>
@endsection
