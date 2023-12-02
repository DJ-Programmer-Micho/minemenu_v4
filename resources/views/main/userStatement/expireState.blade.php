@extends('main.layouts.clean')

@section('content')

<div class="subs-text">
    <div class="row d-flex justify-content-center p-0 m-0 navAR">
        <div>
            <h6 style="font-weight: bold">{{__("Your plan subscription has expired")}}</h6>
        </div>
    </div>
    <section class="price_plan_area d-flex justify-content-center bg p-0 m-0">
        <div class="text-center">
            <div class="col-12 p-1 fail">
                <div class="single_price_plan active wow fadeInUp bo-red" data-wow-delay="0.2s"
                style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="text-center">
                    <h2 style="font-size: 99px;"><i class="fa-solid fa-person-digging"></i></h2>
                </div>
                    <div class="thanks text-center" style="font-size: 24px">
                        <h2 style="font-size: 28px;">{{__("Menu Will Back Soon")}}</h2>
                        <p>{{__("The Menu Is Under Maintenance")}}</p>
                    </div>
                    {{-- <a href="/admin" class="btn btn-success">{{__("Dashboard")}}</a> --}}
                </div>
            </div>

        </div>
</div>
</section>
</div>

@endsection
