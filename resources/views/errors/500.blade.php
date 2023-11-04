@extends('errors::minimal2')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('The page or menu you are searching for does not exist.'))

{{-- @extends('main.layouts.master') --}}
{{-- @section('main_content')

@endsection --}}