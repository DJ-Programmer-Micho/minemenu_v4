@extends('dashboard.rest.layouts.layout')
@section('tail','Menu')
@section('rest_content')

<div>
    @livewire('dashboard.main-menu-livewire')
</div>


@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#menuModal').modal('hide');
        $('#updatemenuModal').modal('hide');
        $('#deletemenuModal').modal('hide');
    })
</script>
@endsection