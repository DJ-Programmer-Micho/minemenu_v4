@extends('main.layouts.master')
@section('main_content')
@php
use App\Models\Plan;
$offerPlan = Plan::where('status', 1)->where('type','offer')->where('valid_date','>',now())->get();
$regularPlans = Plan::where('status', 1)->where('type','regular')->get();
@endphp

<script>
  function updateCountdownTimer(expiryDate, countdownElementId) {
      const countdownElement = document.getElementById(countdownElementId);

      const countdownInterval = setInterval(function () {
          const now = new Date();
          const timeRemaining = expiryDate - now;

          if (timeRemaining <= 0) {
              countdownElement.textContent = 'Offer Expired';
              clearInterval(countdownInterval);
          } else {
              const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
              const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
              const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

              countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
          }
      }, 1000);
  }
</script>
<div class="marg"></div>
    <section class="price_plan_area section_padding_130_80 bg" id="pricing">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12">
              <!-- Section Heading-->
              <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <h5>{{__("Pricing Plans")}}</h5>
                <h3>{{__("Let's find a way together")}}</h3>
                <div class="line my-3"></div>
              </div>
            </div>
          </div>
          <div class="my-3 text-center">
            <h3 class="offer-price">New Offers</h3>
          </div>
          <div class="row justify-content-center">
            @foreach ($offerPlan as $plan)
            <div class="col-12 col-md-6 p-1">
              <div style="border-left: 4px solid #cc0022; border-radius: 5px;">
                <h6 class="ml-2">Expires in: <b><span id="countdown-{{ $plan->id }}"></span></b></h6>
              </div>
              {!! $plan->description[app()->getLocale()] !!}
              <script>
                const offerExpiryDate_{{ $plan->id }} = new Date('{{ $plan->valid_date }}');
                updateCountdownTimer(offerExpiryDate_{{ $plan->id }}, 'countdown-{{ $plan->id }}');
            </script>
            </div>
            @endforeach
          </div>
          <div class="mt-5 my-3 text-center">
            <h3 class="regular-price">Regular Price</h3>
          </div>
          <div class="row justify-content-center">
            <!-- Single Price Plan Area-->
            @foreach ($regularPlans as $plan)
              {!! $plan->description[app()->getLocale()] !!}
            @endforeach

            <div class="col-12 col-sm-8 col-md-6 col-lg-3 p-1">
              <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="title">
                  <h3>{{__("1 - MONTH")}}</h3>
                  <p>{{__("Start Up")}}</p>
                  <div class="line"></div>
                </div>
                <div class="price">
                  <h4>$45/{{__("mo")}}</h4>
                </div>
                <div class="description">
                  <p style="line-height: 19px;"><b>{{__("Charged every month Total amount is $45")}}</b></p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Remove Demo Bar")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("24/7 Support")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Periodic Updates")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Languages")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("All The Designs")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Qr Designs")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("UI Customization")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("User Trainning")}}</p>
                  {{-- <p><i class="fa-solid fa-circle-check"></i>{{__("Video Tutorials")}}</p> --}}
                  {{-- <p><i class="lni lni-close"></i>No Hidden Fees</p>
                  <p><i class="lni lni-close"></i>100+ Video Tuts</p>
                  <p><i class="lni lni-close"></i>No Tools</p> --}}
                </div>
                <div class="button"><a class="btn btn-success btn-2" href="/plans/2">{{__("Get Started")}}</a></div>
              </div>
            </div>
            <!-- Single Price Plan Area-->
            <div class="col-12 col-sm-8 col-md-6 col-lg-3 p-1">
              <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="title">
                  <h3>{{__("6 - MONTHS")}}</h3>
                  <p>{{__("SAVE")}} <b>$52.5</b></p>
                  <div class="line"></div>
                </div>
                <div class="price">
                  <h4>$40/{{__("mo")}}</h4>
                </div>
                <div class="description">
                  <p style="line-height: 19px;"><b>{{__("Charged every 6 months Total amount is $240")}}</b></p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Remove Demo Bar")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("24/7 Support")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Periodic Updates")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Languages")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("All The Designs")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Qr Designs")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("UI Customization")}}</p>
                  <p><i class="fa-solid fa-circle-check"></i>{{__("User Trainning")}}</p>
                  {{-- <p><i class="fa-solid fa-circle-check"></i>{{__("Video Tutorials")}}</p> --}}
                </div>
                <div class="button"><a class="btn btn-success" href="/plans/3">{{__("Get Started")}}</a></div>
              </div>
            </div>
              <!-- Single Price Plan Area-->
              <div class="col-12 col-sm-8 col-md-6 col-lg-3 p-1">
                <div class="single_price_plan active wow fadeInUp bo-red" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                  <!-- Side Shape-->
                  <div class="side-shape"><img src="https://bootdey.com/img/popular-pricing.png" alt=""></div>
                  <div class="title"><span class="bestDeal">{{__("Best Deal")}}</span>
                    <h3>{{__("1 - YEAR")}}</h3>
                    <p>{{__("SAVE")}} <b>$165</b></p>
                    <div class="line"></div>
                  </div>
                  <div class="price">
                    <h4>$31.25/{{__("mo")}}</h4>
                  </div>
                  <div class="description">
                    <p style="line-height: 19px;"><b>{{__("Charged every year Total amount is $375")}}</b></p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Remove Demo Bar")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("24/7 Support")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Periodic Updates")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Languages")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("All The Designs")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Qr Designs")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("UI Customization")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("User Trainning")}}</p>
                    {{-- <p><i class="fa-solid fa-circle-check"></i>{{__("Video Tutorials")}}</p> --}}
                  </div>
                  <div class="button"><a class="btn btn-danger" href="/plans/4">{{__("Get Started")}}</a></div>
                </div>
              </div>
              <!-- Single Price Plan Area-->
              <div class="col-12 col-sm-8 col-md-6 col-lg-3 p-1">
                <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                  <div class="title">
                    <h3>{{__("Upon request")}}</h3>
                    <p>{{__("Enterprise")}} <b></b></p>
                    <div class="line"></div>
                  </div>
                  <div class="price">
                    <h4>{{__("Contact Us")}}</h4>
                  </div>
                  <div class="description">
                    <p style="line-height: 19px;"><b>{{__("Want new Design and be unique, No problem it's easy")}}</b></p>
                    <p><i class="fa-regular fa-circle-check"></i>{{__("All one year plan features, plus:")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Domain Name")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("SSL Certificate")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Custom Hosting")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Custom Design")}}</p>
                    <p><i class="fa-solid fa-circle-check"></i>{{__("Multi Branches")}}</p>
                    {{-- <p><i class="fa-solid fa-circle-check"></i>{{__("Video Tutorials")}}</p> --}}
                  </div>
                  <div class="button"><a class="btn btn-success" href="/contact">{{__("Contact Us")}}</a></div>
                </div>
              </div>
          </div>
        </div>
      </section>
{{-- <h4 class="text-center">Price List<br>COMING SOON</h4> --}}
    <div class="container">
        <div class="text-center text-capitalize">
            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title">{{__("FREE QR code menu for a 14-days")}}</h5>
                    <hr>
                    <p class="card-text">{{__("You can try our QR code menu service first, and then decide does it suits you or not. It's free and we do not ask for your credit card details.")}}</p>
                        <a href="/register" class="btn btn-danger px-5 font-weight-bold">{{__("Try it for free")}}</a>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="marg"></div>


@endsection

