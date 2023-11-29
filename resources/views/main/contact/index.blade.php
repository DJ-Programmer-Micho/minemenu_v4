@extends('main.layouts.master')
@section('main_content')
<div class="marg"></div>
<div class="container contact">
    <h2 class="text-center">{{__("Contact Us")}}</h2>
    <div class="marg"></div>
    <div class="row d-flex justify-content-around">
        <div class="col-lg-6">
            @if (session('success'))
            <p class="alert alert-success ar my-text">{{__("Thank you For Contact Us We'll Reach You Very Soon")}}</p>
            @endif
            <form action="/contactus-whatsapp" class="contact-form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" placeholder="{{__('Your Name')}}" name="name" required>
                    </div>
                    <div class="col-lg-6">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input type="text" placeholder="{{__('Your Email')}}" name="email" required>
                    </div>
                    <div class="col-lg-12 ar-text">
                        @error('message')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <textarea placeholder="{{__('Your Message')}}" name="message" required></textarea >
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        @error('g-recaptcha-response')
                        <span class="danger" style="font-size: 12px">{{__('Please Check reCaptcha')}}</span><br>
                        @enderror
                        <br>
                        <button type="submit">{{__('Submit Now')}}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3">
           <ul class="p-0">
            <li><i class="fa-solid fa-envelope"></i> <a href="">Info@minemenu.com</a></li>
            <li><i class="fa-solid fa-phone"></i><a href="">+964 750 681 4144</a></li>
            <li><i class="fa-solid fa-location-dot"></i> <a href=""> Erbil,Ainkawa</a></li>
           </ul>
        </div>
    </div>
    <div class="marg"></div>
</div>
<div class="marg"></div>
@endsection