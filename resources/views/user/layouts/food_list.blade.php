@extends('user.layouts.layout')
@section('business-content')
<x-business.Food01Component :user="$user" :foodId="$foodId" :ui="$ui" :settings="$setting"/>
@endsection