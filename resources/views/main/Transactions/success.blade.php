@extends('main.layouts.clean')

@section('content')

<div class="subs-text">
    <div class="row d-flex justify-content-center p-0 m-0 navAR">
        <div>
            <h3 style="font-weight: bold">{{__("Your Plan Has Been Upgraded")}}</h3>
        </div>
    </div>
    <section class="price_plan_area d-flex justify-content-center bg p-0 m-0">
        <div class="text-center">
            <div class="col-12 p-1 suc">
                <div class="single_price_plan active wow fadeInUp bo-green" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="thanks text-center" style="font-size: 24px">
                        <h2>{{__("THANK YOU")}}</h2>
                        <p>{{__("Payment Successful!")}}</p>
                    </div>
                    {{-- <div class="text-center">
                        <p>Transaction ID: 145795326542</p>
                        <div class="d-flex justify-content-between">
                            <p>Amount Paid:</p>
                            <p>$375</p>
                        </div>
                    </div> --}}

                    {{-- <button type="submit" value="Submit" id="submitBtn" class="btn btn-danger"><i class="fa-solid fa-file-arrow-down"></i></button> --}}
                    <a href="/rest" class="btn btn-success">{{__("Dashboard")}}</a>
                </div>
            </div>

        </div>
</div>
</section>
</div>

@endsection
