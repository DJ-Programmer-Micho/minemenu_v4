@extends('dashboard.rest.layouts.layout')
@section('tail','Menu')
@section('rest_content')

<div>
    @livewire('dashboard.category-livewire')
</div>


@endsection
@section('rest_script')
<script>
    window.addEventListener('close-modal', event => {
        $('#createCategory').modal('hide');
        $('#updateCategoryModal').modal('hide');
        $('#deleteCategoryModal').modal('hide');
    })
</script>
<script>
    window.addEventListener('close-mini-modal', event => {
        $('#galleryFoodCategory').modal('hide');
        $('#galleryCoverCategory').modal('hide');
    })
</script>
@endsection