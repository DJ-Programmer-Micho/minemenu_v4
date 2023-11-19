<!-- Begin Page Content -->
@php
use App\Models\Plan;
$offerPlan = Plan::where('status', 1)->where('type','offer')->where('valid_date','>',now())->get();
$regularPlans = Plan::where('status', 1)->where('type','regular')->get();
$userExp = false; 
if(auth()->user()->subscription->expire_at <= now()){
    $userExp = true; 
}
// dd($offerPlan);
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
<div>
    @if($userExp == true)
    <div class="alert alert-danger mt-2" role="alert">
        You Account has been expired, Please Select the plan to renew or contact with support team</a>
      </div>
    @endif
    <section class="price_plan_area section_padding_130_80 bg" id="pricing">
        <div class="row justify-content-center">
            <div class="col-12  col-lg-6">
                <!-- Section Heading-->
                <div class="section-heading text-center wow fadeInUp mt-5" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <h6>{{__("Pricing Plans")}}</h6>
                    <h3>{{__("Let's find a way together")}}</h3>
                    <div class="line my-3"></div>
                </div>
            </div>
        </div>
        @if(!empty($offerPlan))
        <div class="my-3 text-center">
            <h3 class="offer-price">New Offers</h3>
          </div>
          <div class="row justify-content-center">
            @foreach ($offerPlan as $plan)
            <div class="col-12 col-md-6 p-1">
              <div style="border-left: 4px solid #cc0022; border-radius: 5px;">
                <h6 class="ml-2">Expires in: <b><span id="countdown-{{ $plan->id }}"></span></b></h6>
              </div>
              {{-- {!! $plan->description_rest[app()->getLocale()] !!} --}}

            @php
              $blade = new \Illuminate\View\Compilers\BladeCompiler(app('files'), app('config')->get('view.compiled'));
              $renderedContent = $blade->compileString($plan->description_rest[app()->getLocale()]);
              eval('?>' . $renderedContent . '<?php');
            @endphp
          
              <script>
                const offerExpiryDate_{{ $plan->id }} = new Date('{{ $plan->valid_date }}');
                updateCountdownTimer(offerExpiryDate_{{ $plan->id }}, 'countdown-{{ $plan->id }}');
            </script>
            </div>
            @endforeach
          </div>
          @endif
          <div class="mt-5 my-3 text-center">
            <h3 class="regular-price">Regular Price</h3>
          </div>
        <div class="row justify-content-center">
            @foreach ($regularPlans as $plan)
            @php
            $blade = new \Illuminate\View\Compilers\BladeCompiler(app('files'), app('config')->get('view.compiled'));
            $renderedContent = $blade->compileString($plan->description_rest[app()->getLocale()]);
            eval('?>' . $renderedContent . '<?php');
          @endphp
            @endforeach

            <!-- Single Price Plan Area-->
            <div class="col-12 col-md-6 p-1 mb-4 text-white">
                <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    {{-- <span class="cPlan badgeTag_currentplan">{{__("Current Plan")}}</span> --}}
                    <div class="title">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{__("Upon request")}}</h3>
                                <p>{{__("Enterprise")}}</p>
                            </div>
                            <div class="price">
                                <h4>{{__("Contact Us")}}</h4>
                            </div>
                        </div>
                        <div class="line w-100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="line-height: 19px;">
                            <b>{{__("Want new Design and be unique, No problem it's easy")}}</b></p>
                        <button class="btn btn-danger p-1" type="button" data-toggle="collapse"
                            data-target="#collapsecontact" aria-expanded="false" aria-controls="collapseExample">Read
                            More
                        </button>
                    </div>
                    <div class="collapse" id="collapsecontact">
                        <p><i class="fa-regular fa-circle-check"></i> {{__("All one year plan features, plus:")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Domain Name")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("SSL Certificate")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Custom Hosting")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Custom Design")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Branches")}}</p>
                    </div>
                    <a class="btn btn-success btn-2" href="/contact">{{__("Contact Us")}}</b></a>
                </div>
            </div>
        </div>
    </section>

</div>
