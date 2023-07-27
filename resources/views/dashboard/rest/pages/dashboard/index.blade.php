@extends('dashboard.rest.layouts.layout')
@section('tail','Dashboard')
@section('rest_content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <x-dashboard.general_report/>

        <div class="col-span-12 lg:col-span-6 mt-8">
            <x-dashboard.chart_one/>
        </div>
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <x-dashboard.pie_one/>
        </div>
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <x-dashboard.pie_two/>
        </div>
    </div>
    <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
        <x-dashboard.transaction/>
    </div>
</div>
@endsection