@extends('main.layouts.clean')

@section('content')

<div class="subs-text">
    <div class="row d-flex justify-content-center p-0 m-0 navAR">
        <div>
            <h3 style="font-weight: bold">{{__("Try Again Later!")}}</h3>
        </div>
    </div>
    <section class="price_plan_area d-flex justify-content-center bg p-0 m-0">
        <div class="text-center">

            <div class="col-12 p-1 fail">
                <div class="single_price_plan active wow fadeInUp bo-red" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="thanks text-center" style="font-size: 24px">
                        <h2>{{__("Oh No!")}}</h2>
                        <p>{{__("Failed Payment Process")}}</p>
                    </div>
                    <div class="description">
                        <p style="line-height: 19px;"><b>{{__("Reasons of Failed Payment:")}}</b>
                        </p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("Faulty internet connection")}}</p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("Entering incorrect payment details")}}</p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("There is not enough Balance")}}</p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("Payment method not supported")}}</p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("Downtime and/or maintenance")}}</p>
                        <p class="subsT"><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ffc107;"></i>{{__("Check Your BanK")}}</p>
                    </div>

                    <a href="/" class="btn btn-danger">{{__("Home")}}</a>
                </div>
            </div>

        </div>
</div>
</section>
</div>

@endsection
