@extends('dashboard.rest.layouts.layout')
@section('tail','Profile')
@section('rest_content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Profile Layout
    </h2>
</div>
<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="dist/images/profile-4.jpg">
                <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-theme-1 rounded-full p-2"> <i class="w-4 h-4 text-white" data-feather="camera"></i> </div>
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{auth()->user()->profile->fullname}}</div>
                <div class="text-gray-600">Returant Owner</div>
            </div>
        </div>
        <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{auth()->user()->email}} </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{auth()->user()->profile->phone}} </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="user" class="w-4 h-4 mr-2"></i> {{auth()->user()->name}} </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
            <div class="font-medium text-center lg:text-left lg:mt-5">Registration Date</div>
            <div class="flex items-center justify-center lg:justify-start mt-2">
                <div class="mr-2 w-60 flex"> Register Date: <span class="ml-3 font-medium text-theme-9"> 03/05/2023 </span> </div>

            </div>
            <div class="flex items-center justify-center lg:justify-start">
                <div class="mr-2 w-60 flex"> Expire Date: <span class="ml-3 font-medium text-theme-6"> 03/05/2024 </span> </div>

            </div>
        </div>
    </div>
    <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start"> 
        <a href="" class="button text-white bg-theme-1 shadow-md my-3 mx-1">Edit Profile</a>
        <a href="" class="button text-white bg-theme-1 shadow-md my-3 mx-1">Change Password</a>
        <a href="" class="button text-white bg-theme-1 shadow-md my-3 mx-1">Check Users</a>
    </div>
</div>
<!-- END: Profile Info -->
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