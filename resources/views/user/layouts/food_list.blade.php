@extends('user.layouts.layout')
@section('business-content')
<x-business.food01component :user="$user" :foodId="$foodId" :ui="$ui" :settings="$setting"/>
@endsection