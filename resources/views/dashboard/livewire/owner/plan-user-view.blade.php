<!-- Begin Page Content -->
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
    <section class="price_plan_area section_padding_130_80 bg" id="pricing">
        <div class="row justify-content-center">
            <div class="col-12  col-lg-6">
                <!-- Section Heading-->
                <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <h6>{{__("Pricing Plans")}}</h6>
                    <h3>{{__("Let's find a way together")}}</h3>
                    <div class="line my-3"></div>
                </div>
            </div>
        </div>
        <div class="my-3 text-center">
            <h3 class="offer-price">New Offers</h3>
          </div>
          <div class="row justify-content-center w-100">
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
        <div class="row justify-content-center w-100">
            @foreach ($regularPlans as $plan)
              {!! $plan->description_rest[app()->getLocale()] !!}
            @endforeach
            <div class="col-12 col-md-6 p-1 mb-4 text-white">
                <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="title">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{__("1 - MONTH")}}</h3>
                                <p>{{__("Start Up")}}</p>
                            </div>
                            <div class="price">
                                <h4>$45/{{__("mo")}}</h4>
                            </div>
                        </div>
                        <div class="line w-100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="line-height: 19px;"><b>{{__("Charged every month Total amount is $45")}}</b></p>
                        <button class="btn btn-danger p-1" type="button" data-toggle="collapse"
                            data-target="#collapse1month" aria-expanded="false" aria-controls="collapseExample">Read
                            More
                        </button>
                    </div>
                    <div class="collapse" id="collapse1month">
                        <p><i class="far fa-check-circle"></i> {{__("Remove Demo Bar")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("24/7 Support")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Periodic Updates")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Languages")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("All The Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Qr Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("UI Customization")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("User Trainning")}}</p>
                    </div>
                    <a class="btn btn-success btn-2" href="/plans/2"><b>{{__("Get Started")}}</b></a>
                </div>
            </div>
            <!-- Single Price Plan Area-->
            <div class="col-12 col-md-6 p-1 mb-4 text-white">
                <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="title">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{__("6 - MONTHS")}}</h3>
                                <p>{{__("SAVE")}} <b>$52.5</b></p>
                            </div>
                            <div class="price">
                                <h4>$40/{{__("mo")}}</h4>
                            </div>
                        </div>
                        <div class="line w-100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="line-height: 19px;"><b>{{__("Charged every 6 months Total amount is $240")}}</b></p>
                        <button class="btn btn-danger p-1" type="button" data-toggle="collapse"
                            data-target="#collapse6months" aria-expanded="false" aria-controls="collapseExample">Read
                            More
                        </button>
                    </div>
                    <div class="collapse" id="collapse6months">
                        <p><i class="far fa-check-circle"></i> {{__("Remove Demo Bar")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("24/7 Support")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Periodic Updates")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Languages")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("All The Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Qr Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("UI Customization")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("User Trainning")}}</p>
                    </div>
                    <a class="btn btn-success btn-2" href="/plans/3"><b>{{__("Get Started")}}</b></a>
                </div>
            </div>
            <!-- Single Price Plan Area-->
            <div class="col-12 col-md-6 p-1 mb-4 text-white">
                <div class="single_price_plan wow fadeInUp bo-green active" data-wow-delay="0.2s"
                    style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <!-- Side Shape-->
                    {{-- <div class="side-shape"><img src="https://bootdey.com/img/popular-pricing.png" alt=""></div> --}}
                    <span class="bestDeal badgeTag_bestDeal">{{__("Best Deal")}}</span>
                    <div class="title">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>{{__("1 - YEAR")}}</h3>
                                <p>{{__("SAVE")}} <b>$165</b></p>
                            </div>
                            <div class="price">
                                <h4>$31.25/{{__("mo")}}</h4>
                            </div>
                        </div>
                        <div class="line w-100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p style="line-height: 19px;"><b>{{__("Charged every year Total amount is $375")}}</b></p>
                        <button class="btn btn-danger p-1" type="button" data-toggle="collapse"
                            data-target="#collapse1year" aria-expanded="false" aria-controls="collapseExample">Read More
                        </button>
                    </div>
                    <div class="collapse" id="collapse1year">
                        <p><i class="far fa-check-circle"></i> {{__("Remove Demo Bar")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("24/7 Support")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Periodic Updates")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Languages")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("All The Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("Multi Qr Designs")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("UI Customization")}}</p>
                        <p><i class="far fa-check-circle"></i> {{__("User Trainning")}}</p>
                    </div>
                    <a class="btn btn-success btn-2" href="/plans/4"><b>{{__("Get Started")}}</b></a>
                </div>
            </div>
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
