@extends('dashboard.rest.layouts.layout')
@section('tail','Menu')
@section('rest_content')

<div>
    @livewire('dashboard.user-table3')
</div>


@endsection
@section('rest_script')
<script>
    // alert('asd')
    window.addEventListener('close-modal', event => {
 
        $('#studentModal').modal('hide');
        $('#updateStudentModal').modal('hide');
        $('#deleteStudentModal').modal('hide');
    })
</script>
@endsection