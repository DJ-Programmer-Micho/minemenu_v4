@extends('dashboard.rest.layouts.layout')
@section('tail','Offer')
@section('rest_content')
<div>
    @livewire('dashboard.offer-livewire')
</div>
@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createOffer').modal('hide');
        $('#updateOfferModal').modal('hide');
        $('#deleteOfferModal').modal('hide');
    })
</script>
@endsection