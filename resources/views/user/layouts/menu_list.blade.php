@extends('user.layouts.layout')
@section('business-content')
<x-business.Body01Component :user="$user" :setting="$setting" :ui="$ui"/>
@endsection