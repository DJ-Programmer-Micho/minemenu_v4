@extends('user.index.ui-1.layouts.layout')
@section('business-content')
<x-business.food01component :user="$user" :foodId="$foodId" :ui="$ui" :settings="$setting"/>
@endsection