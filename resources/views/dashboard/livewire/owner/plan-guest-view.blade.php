{{-- <link rel="stylesheet" href="{{asset('/assets/main/css/style.css')}}"> --}}
<style>
    
.price_plan_area {
    position: relative;
}

.single_price_plan {
    position: relative;
    z-index: 1;
    /* border-radius: 0.5rem 0.5rem 0 0; */
    border-radius: 0.5rem;
    -webkit-transition-duration: 500ms;
    transition-duration: 500ms;
    /* margin-bottom: 50px; */
    background-color: #ffffff;
    padding: 1rem 1rem;
	/* border: 2px solid #000; */

}

.single_price_plan:lang(ar){
	direction: rtl;
    text-align: right;
}

.single_price_plan::after {
    position: absolute;
    content: "";
    /* background-image: url("https://bootdey.com/img/half-circle-pricing.png"); */
    background-repeat: repeat;
    width: 100%;
    height: 17px;
    bottom: -17px;
    z-index: 1;
    left: 0;
}

.single_price_plan .title {
    text-transform: capitalize;
    -webkit-transition-duration: 500ms;
    transition-duration: 500ms;
    margin-bottom: 2rem;
}
.single_price_plan .title span {
    color: #ffffff;
    padding: 0.2rem 0.6rem;
    font-size: 10px;
    text-transform: uppercase;
    background-color: #2ecc71;
    display: inline-block;
    margin-bottom: 0.5rem;
    border-radius: 0.25rem;
}
.single_price_plan .title h3 {
    font-size: 1.25rem;
}
.single_price_plan .title p {
    font-weight: 300;
    line-height: 1;
    font-size: 14px;
}
.single_price_plan .title .line {
    width: 80px;
    height: 4px;
    border-radius: 20px;
    background-color: #cc0033;
}
.single_price_plan .price {
    margin-bottom: 1.5rem;
}
.single_price_plan .price h4 {
    position: relative;
    z-index: 1;
    font-size: 2rem;
    /* line-height: 1; */
    margin-bottom: 0;
    display: inline-block;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-color: transparent;
    background-image: -webkit-gradient(linear, left top, right top, from(#ee0033), to(#ff0022));
    background-image: linear-gradient(90deg, #cc0022, #ff0055);
}
.offer-price {
    position: relative;
    z-index: 1;
    font-size: 2rem;
    /* line-height: 1; */
    margin-bottom: 0;
    display: inline-block;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-color: transparent;
    background-image: -webkit-gradient(linear, left top, right top, from(#ffb300), to(#a57c00 ));
    background-image: linear-gradient(90deg, #ffb300, #a57c00 );
}
.regular-price {
    position: relative;
    z-index: 1;
    font-size: 2rem;
    /* line-height: 1; */
    margin-bottom: 0;
    display: inline-block;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-color: transparent;
    background-image: -webkit-gradient(linear, left top, right top, from(#cc0022), to(#ff0055 ));
    background-image: linear-gradient(90deg, #cc0022, #ff0055 );
}
.single_price_plan .thanks h2 {
	position: relative;
	z-index: 1;
	font-size: 3rem;
	/* line-height: 1; */
	margin-bottom: 0;
	display: inline-block;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	background-color: transparent;
	background-image: -webkit-gradient(linear, left top, right top, from(#ee0033), to(#ff0022));
	background-image: linear-gradient(90deg, #cc0022, #ff0055);
  }
.single_price_plan .description {
    position: relative;
    margin-bottom: 1.5rem;
}
.bo-red{
	border: 2px solid red ;
}
.bo-green{
	border: 2px solid rgb(7, 104, 59) ;
	}
.bo-yellow{
	border: 2px solid rgb(250, 218, 94) ;
	}
.single_price_plan .description p {
    line-height: 16px;
    margin: 0;
    padding: 10px 0;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -ms-grid-row-align: center;
    align-items: center;
}
.single_price_plan .description p i {
    color: #2ecc71;
    margin: 0 0.5rem;
}
.single_price_plan .description p .lni-close {
    color: #e74c3c;
}
.single_price_plan.active,
.single_price_plan:hover,
.single_price_plan:focus {
    -webkit-box-shadow: 0 6px 50px 8px rgba(255, 43, 23, 0.15);
    box-shadow: 0 6px 50px 8px rgba(255, 43, 23, 0.15);
}
.suc .single_price_plan.active,
.suc .single_price_plan:hover,
.suc .single_price_plan:focus {
	-webkit-box-shadow: 0 6px 50px 8px rgba(23, 255, 127, 0.15)!important;
	box-shadow: 0 6px 50px 8px rgba(23, 255, 127, 0.15)!important;
}
.can .single_price_plan.active,
.can .single_price_plan:hover,
.can .single_price_plan:focus {
	-webkit-box-shadow: 0 6px 50px 8px rgba(250, 218, 94, 0.15)!important;
	box-shadow: 0 6px 50px 8px rgba(250, 218, 94, 0.15)!important;
}

.single_price_plan .side-shape img {
    position: absolute;
    width: auto;
    top: 0;
    right: 0;
    z-index: -2;
}


.bestDeal{
	font-size: 21px!important;
	position: absolute; 
	right: 10px;
}

[lang = "ar"] .bestDeal {
	right: auto;
	left: 10px;
}


@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .single_price_plan {
        padding: 1rem;
    }
	.bestDeal{
		font-size: 19px!important;
	}
}
@media only screen and (max-width: 575px) {
    .single_price_plan {
        padding: 1rem;
    }
}


.section-heading h3 {
    margin-bottom: 1rem;
    font-size: 3.125rem;
    letter-spacing: -1px;
}

.section-heading p {
    margin-bottom: 0;
    font-size: 1.25rem;
}

.section-heading .line {
    width: 120px;
    height: 5px;
    margin: 30px auto 0;
    border-radius: 6px;
    background: #cc0099;
    background: -webkit-gradient(linear, left top, right top, from(#ee0033), to(#ff0022));
    background: linear-gradient(to right, #cc0022, #ff0055);
}
</style>
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
<div class="marg"></div>