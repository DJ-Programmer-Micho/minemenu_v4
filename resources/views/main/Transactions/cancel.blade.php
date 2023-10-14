@extends('main.layouts.clean')

@section('content')

<div class="subs-text">
    <div class="row d-flex justify-content-center p-0 m-0 navAR">
        <div>
            <h3 style="font-weight: bold">{{__("Is There Somthing Wrong?")}}</h3>
        </div>
    </div>
    <section class="price_plan_area d-flex justify-content-center bg p-0 m-0">
        <div class="text-center">
            <div class="col-12 p-1 can">
                <div class="single_price_plan active wow fadeInUp bo-yellow" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="thanks text-center" style="font-size: 24px">
                        <h2>{{__("?")}}</h2>
                        <p>{{__("Cancel Payment Process")}}</p>
                    </div>
                    <div class="description">
                        <p style="line-height: 19px;"><b>{{__("If you need any help, please contact us:")}}</b></p>
                        <p class="subsT"><i class="fa-solid fa-envelope"></i><a
                                href="mailto:support@minemenu.com">{{__("support@minemenu.com")}}</a></p>
                        <p class="subsT"><i class="fa-solid fa-headset"></i><a
                                href="tel:+9647506814144">{{__("+964 750 68 14 144")}}</a></p>
                        <p class="subsT"><i class="fa-solid fa-address-card"></i><a
                                href="/contact">{{__("Contact Page")}}</a></p>
                    </div>

                    <a href="/" class="btn btn-warning">{{__("Home")}}</a>
                </div>
            </div>

        </div>
</div>
</section>
</div>

@endsection
