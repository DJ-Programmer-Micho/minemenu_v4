@extends('main.layouts.master')
@section('main_content')
<div class="container">
    <header class="" style="margin-top:10%">
        <div class="row d-flex justify-content-between ar">
            <div class="col-lg-6 mb-3">
                <h2 class="my-text">{{__("Get Your Own E-Menu")}}</h2>
                <h5 class="pt-3 my-text text-capitalize">
                    {{__('Create a visually appealing E-Menu for your restaurant, coffee shop, bakery, hotel, and more in just 5 minutes! Enjoy unlimited design options with a variety of colors to perfectly match your website.')}}
                </h5>
                <p class="my-text">
                    <a href="/register" class="btn btn-danger my-3 p-2">{{__("Start your 14-day free trial now!")}}</a>
                </p>
            </div>
            <div class="col-lg-6 text-right">
                <img class="h-img" src="{{app('cloudfront').'mine-setting/main-page/main5.png' }}" alt="Mine-Menu" title="Mine-Menu">
            </div>
        </div>
    </header>
    <div class="marg"></div>
    <section>
        <div class="row d-flex justify-content-center tm-col-md-reverse ar">
            <div class="col-lg-6 mb-4">
                <img src="{{app('cloudfront').'mine-setting/main-page/main2.png' }}" alt="mine menu">
            </div>
            <div class="col-lg-6 mb-5">
                <h3 class="my-text">{{__("The Designs?")}}</h3>
                <p class="my-text">
                    {{__("Experience the best in UI design with consistent colors and adaptable shapes for various screen sizes. Our platform prioritizes UI and user experience design, adhering to the latest industry standards. The result is a practical, user-friendly interface and an enhanced menu experience. Customize your menu effortlessly by adjusting colors, images, and design to match your restaurant's unique style.")}}
                </p>
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/cat02.jpg' }}" alt="mine menu">
            </div>
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/food01.jpg' }}" alt="mine menu">
            </div>
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/Ofr04.jpg' }}" alt="mine menu">
            </div>
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/Ofr02.jpg' }}" alt="mine menu">
            </div>
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/cat06.jpg' }}" alt="mine menu">
            </div>
            <div class="col-6 col-md-2 my-1">
                <img src="{{app('cloudfront').'mine-setting/ui-ux/food03.jpg' }}" alt="mine menu">
            </div>
        </div>
    </section>
    {{-- <h1>        
    @php
       echo Hash::make('');
    @endphp</h1> --}}
    <div class="marg"></div>
    <section>
        <div class="row d-flex justify-content-between ar">
            <div class="col-lg-6">
                <h3 class="my-text">{{__("Connect your menu seamlessly with a QR code.")}}</h3>
                <p class=" my-text">
                    {{__("Generate diverse QR code designs, effortlessly print them for table placement, or share the QR code/menu link on your social media. Increased visits elevate your menu's rank in our thriving Mine Menu community. Start boosting your menu visibility today!")}}
                </p>
            </div>
            <div class="col-lg-6">
            <div class="row">
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053030846383.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053032603219.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053036380918.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053037281443.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053034321365.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053217341549.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053221957222.jpeg' }}" alt="mine menu">
                </div>
                <div class="col-3 col-md-3 my-1">
                    <img src="{{app('cloudfront').'mine-setting/qr_code_ad/Michel_qr_2024150117053224138328.jpeg' }}" alt="mine menu">
                </div>
            </div>
            </div>
        </div>
    </section>
    <div class="marg"></div>
    <section>
        <div class="row d-flex justify-content-center tm-col-md-reverse ar">
            <div class="col-lg-6">
                <img src="{{app('cloudfront').'mine-setting/main-page/main4.png' }}" alt="mine menu">
            </div>
            <div class="col-lg-6 mb-5 ar">
                <h3 class="my-text">{{__("Full Management Of Your Menu")}}</h3>
                <p class="my-text">
                    {{__("Effortlessly update your menu in real-time, maintaining complete control over your online menu. Add, activate, deactivate menu items, update prices swiftly, and access analytics and scan reports on any device. Experience the convenience of full menu management!")}}
                </p>
                <p class="ar-youtube">
                    {{__('Explore our dashboard features through our YouTube videos!')}}<br>
                    <a href="https://www.youtube.com/watch?v=vpNjtz_1j3Q&list=PLQe1kP4aCPRaKxCgNOOLTjHbj6SrI_y5M" class="btn btn-danger my-3 p-2" target="_blank">{{__("Youtube")}}</a>
                </p>
            </div>
        </div>
    </section>
    <div class="marg"></div>
    @php
    use App\Models\User;
    use App\Models\TopUsers;
    $menus_id = TopUsers::first()->menus_id ?? null;
    $menus = User::find($menus_id);
@endphp
@if(!empty($menus_id))

<section class="testimonial text-center">
    <h6 style="margin-top:10px;font-weight:600">{{__('TOP 4 MENUS')}}</h6>
    <h2 style="margin-bottom:60px;font-weight:600">{{__('Check Our Clients Menu')}}</h2>

    <div class="row">
        @foreach ($menus as $menu)
        <div class="col-6 col-lg-3 testimonial-cards">
                <a href="{{env('APP_URL').$menu->name}}" target="_blank" style="text-decoration: none;" class="text-dark">
                <div>
                    <img src="https://d7tztcuqve7v9.cloudfront.net/{{$menu->settings->background_img_avatar ?? app('logo_144_show')}}" alt="minemenu {{$menu->name}}">
                    <h6 class="mt-2">{{$menu->name}}</h6>
                </div>
            </a>
            </div>
        @endforeach
    </div>
</section>
@endif
    <div class="marg"></div>
    <section class="features text-center">
        <h2 style="margin-bottom:10px;font-weight:600">{{__('What We Offer')}}</h2>
        <div class="row features-cards">
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/sup2.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="mt-2">{{__("24 Hours Support")}}</h5>
                <p>{{__("We Provide you a 24/7 online support with a professional team.")}}</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/up4.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="mt-2">{{__("Periodic Updates")}}</h5>
                <p>{{__("There will Always be updates and new features added to your menu and system.")}}</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/lang.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="mt-2">{{__("Multi Languages")}}</h5>
                <p>{{__("Your menu will be written in multi languages very easly.")}}</p>
            </div>
        </div>

        <div class="row features-cards">
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/tut.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="">{{__("User Trainning")}}</h5>
                <p>{{__("You will be provided with a full tutorial about how to manage your menu.")}}</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/qr.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="mt-2">{{__("Multi Qr Designs")}}</h5>
                <p>{{__("There will be a lot of different designes to choose for your menu Qr code.")}}</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-icon"><img src="{{asset('/assets/main/img/iconsmain/ui.png')}}" height="100%" width="100%"
                        alt="Mine-menu"></div>
                <h5 class="mt-2">{{__("UI Customization")}}</h5>
                <p>{{__("With our system you can customize your UI and create different views according to you preference.")}}
                </p>
            </div>
        </div>
    </section>

    <div class="marg"></div>
    <section>
        <div class="container-xxl py-5 faqsSection">
            <div class="container">
                <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-6">{{__('FAQs')}}</h1>
                    <p class="text-dark fs-5 mb-5">{{__('Frequently Asked Questions')}}</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-header p-0" id="headingOne">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{__('How do I sign up?')}}
                                  </button>
                                </h2>
                              </div>
                          
                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('Click on the Register button, enter the required information, and submit. After that, you will need to verify your email and phone number.')}}<br>
                                  {{__('You can check our Instruction page for the steps.')}}<br>
                                  <a href="/documentation" class="btn btn-danger my-3 p-2" target="_blank">{{__("Documentation")}}</a>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingTwo">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{__('How does the QR Code work?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('You can easily generate your own QR Code design, and it will automatically redirect to your menu when scanned by any device. To set this up, register and go to the dashboard. Click on Menu Design and then select QR Code. You will have a panel to customize all aspects of the QR Code.')}}
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingThree">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{__('How many Items I can add to my menu?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('There is no limit to the number of items you can add to your menu. You have the flexibility to include as many items as needed to showcase your offerings effectively.')}}
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingFour">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    {{__('Does the QR code in Mine Menu work with all devices?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('The QR code in Mine Menu is designed to work seamlessly with all devices, ensuring a universal and user-friendly experience across various platforms.')}}
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingFive">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    {{__('Do I need to buy a domain and hosting?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('No, you do not need to. Mine Menu will create a new redirection for your menu as a sub-server. Also, our servers are located in three different countries. By registering and choosing the country, your menu will be served in the nearest country to your location.')}}
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingSix">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    {{__('Are there any contracts? What are my terms?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('You will encounter two sets of terms and conditions, including a privacy policy. The first set appears during registration, where you will find a link to accept the terms. The second set comes into play when subscribing to the paid version, encompassing additional terms. Both sets are focused on safeguarding your data from external entities.')}}
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header p-0" id="headingSeven">
                                <h2 class="mb-0">
                                  <button class="btn btn-danger btn-block text-left collapsed" style="border-bottom: 1px solid #cc0022" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    {{__('Is it free or not?')}}
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                                <div class="card-body">
                                  {{__('As a new registrant, you have a 14-day free trial. After this period, your menu will cease to be available online unless you purchase a package, which is detailed in the pricing page.')}}
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="book-section text-center">
  <div>
    <h2>{{__('You Still Confused?')}}</h2>
    <h4>{{__('Start Your 14 Days Free Trail Now')}}</h4>
    <p class="">
      <a href="/register" class="btn btn-danger my-3 p-2">{{__('Book Your Menu Now')}}</a>
    </p>
  </div>
  <hr>
  <div class="container" style="max-width: 300px">
    <div class="d-flex justify-content-between social-m">
      <style>
        .social-m i{
          margin-bottom: 5px; 
          margin-top: 5px; 
          font-size: 36px;
          color: white;
        }
        .social-m i:hover{
          color: #cc0022;
        }
      </style>
      <a href="https://www.facebook.com/minemenuiq" target="_blank">
          <i class="fab fa-facebook-square"></i>
      </a>
      <a href="https://www.instagram.com/minemenuiq/" target="_blank">
          <i class="fab fa-instagram"></i>
      </a>
      <a href="https://www.youtube.com/@mine_menu" target="_blank">
        <i class="fab fa-youtube"></i>
      </a>
      <a href="https://t.me/minemenuiraq" target="_blank">
          <i class="fab fa-telegram"></i>
      </a>
    </div>
  </div>


</section>

@endsection