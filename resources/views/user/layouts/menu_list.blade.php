@extends('user.layouts.layout')
@section('business-content')
<x-business.body01component :user="$user" :setting="$setting" :ui="$ui"/>
@endsection