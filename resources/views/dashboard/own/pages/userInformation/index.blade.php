@extends('dashboard.own.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')

<div>
    @livewire('owner.user-information-livewire')
</div>
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createUser').modal('hide');
        $('#updateUserModal').modal('hide');
        $('#moduleUserModal').modal('hide');
    })
</script>
@endsection
@endsection